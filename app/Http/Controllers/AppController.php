<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{App, Device, DeviceAppInstall};
use App\Services\ApkService;
use App\Http\Requests\StoreAppRequest;
use Illuminate\Support\Facades\Storage;

class AppController extends Controller
{
    protected $apkService;

    public function __construct(ApkService $apkService)
    {
        $this->apkService = $apkService;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', App::class);

        $apps = App::with(['uploadedBy', 'deviceInstalls'])
                   ->when($request->channel, fn($q) => $q->where('channel', $request->channel))
                   ->when($request->status, fn($q) => $q->where('status', $request->status))
                   ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                                                       ->orWhere('package_name', 'like', "%{$request->search}%"))
                   ->latest()
                   ->paginate(20);

        $stats = [
            'total_apps' => App::count(),
            'active_apps' => App::where('status', App::STATUS_ACTIVE)->count(),
            'total_installs' => DeviceAppInstall::count(),
            'channels' => App::selectRaw('channel, count(*) as count')
                            ->groupBy('channel')
                            ->pluck('count', 'channel'),
        ];

        return view('apps.index', compact('apps', 'stats'));
    }

    public function create()
    {
        $this->authorize('create', App::class);
        return view('apps.create');
    }

    public function store(StoreAppRequest $request)
    {
        $this->authorize('create', App::class);

        try {
            $app = $this->apkService->uploadApp($request->validated(), $request->file('apk_file'));
            
            return redirect()->route('apps.show', $app)
                           ->with('success', 'App uploaded successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['apk_file' => $e->getMessage()]);
        }
    }

    public function show(App $app)
    {
        $this->authorize('view', $app);

        $app->load(['uploadedBy', 'deviceInstalls.device.user']);
        
        $stats = [
            'total_installs' => $app->deviceInstalls()->count(),
            'active_installs' => $app->deviceInstalls()->where('is_active', true)->count(),
            'recent_installs' => $app->deviceInstalls()
                                    ->with(['device.user'])
                                    ->latest('installed_at')
                                    ->take(10)
                                    ->get(),
        ];

        $versions = App::where('package_name', $app->package_name)
                      ->where('channel', $app->channel)
                      ->orderBy('version_code', 'desc')
                      ->get();

        return view('apps.show', compact('app', 'stats', 'versions'));
    }

    public function edit(App $app)
    {
        $this->authorize('update', $app);
        return view('apps.edit', compact('app'));
    }

    public function update(Request $request, App $app)
    {
        $this->authorize('update', $app);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'channel' => 'required|in:internal,beta,stable',
            'status' => 'required|in:active,deprecated,disabled',
            'changelog' => 'nullable|string',
        ]);

        $app->update($validated);

        return redirect()->route('apps.show', $app)
                       ->with('success', 'App updated successfully');
    }

    public function destroy(App $app)
    {
        $this->authorize('delete', $app);

        // Delete file from storage
        if (Storage::exists($app->file_path)) {
            Storage::delete($app->file_path);
        }

        $app->delete();

        return redirect()->route('apps.index')
                       ->with('success', 'App deleted successfully');
    }

    public function download(App $app)
    {
        $this->authorize('download', $app);

        if (!Storage::exists($app->file_path)) {
            abort(404, 'App file not found');
        }

        // Log download if user is authenticated
        if (auth()->check()) {
            $app->logActivity('downloaded');
        }

        return Storage::download($app->file_path, $app->name . '_v' . $app->version_name . '.apk');
    }

    public function upload()
    {
        $this->authorize('create', App::class);
        return view('apps.upload');
    }

    public function bulkAction(Request $request)
    {
        $this->authorize('update', App::class);

        $validated = $request->validate([
            'action' => 'required|in:activate,deactivate,delete,change_channel',
            'app_ids' => 'required|array',
            'app_ids.*' => 'exists:apps,id',
            'channel' => 'required_if:action,change_channel|in:internal,beta,stable',
        ]);

        $apps = App::whereIn('id', $validated['app_ids'])->get();

        foreach ($apps as $app) {
            switch ($validated['action']) {
                case 'activate':
                    $app->update(['status' => App::STATUS_ACTIVE]);
                    break;
                case 'deactivate':
                    $app->update(['status' => App::STATUS_DISABLED]);
                    break;
                case 'delete':
                    if (Storage::exists($app->file_path)) {
                        Storage::delete($app->file_path);
                    }
                    $app->delete();
                    break;
                case 'change_channel':
                    $app->update(['channel' => $validated['channel']]);
                    break;
            }
        }

        return back()->with('success', 'Bulk action completed successfully');
    }

    public function analytics(App $app)
    {
        $this->authorize('view', $app);

        $installStats = DeviceAppInstall::where('app_id', $app->id)
                                       ->selectRaw('DATE(installed_at) as date, COUNT(*) as installs')
                                       ->groupBy('date')
                                       ->orderBy('date')
                                       ->get();

        $deviceStats = DeviceAppInstall::where('app_id', $app->id)
                                      ->join('devices', 'device_app_installs.device_id', '=', 'devices.id')
                                      ->selectRaw('devices.manufacturer, COUNT(*) as count')
                                      ->groupBy('devices.manufacturer')
                                      ->orderBy('count', 'desc')
                                      ->get();

        return view('apps.analytics', compact('app', 'installStats', 'deviceStats'));
    }
}