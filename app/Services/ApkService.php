<?php

namespace App\Services;

use App\Models\App;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApkService
{
    public function uploadApp(array $data, UploadedFile $file): App
    {
        // Validate APK file
        $this->validateApkFile($file);
        
        // Extract APK metadata
        $metadata = $this->extractApkMetadata($file);
        
        // Generate file path
        $fileName = Str::uuid() . '.apk';
        $filePath = 'apks/' . $fileName;
        
        // Store file
        $storedPath = Storage::putFileAs('apks', $file, $fileName);
        
        // Calculate file hash
        $fileHash = hash_file('sha256', $file->getRealPath());
        
        // Check for duplicate
        $existing = App::where('file_hash', $fileHash)->first();
        if ($existing) {
            Storage::delete($storedPath);
            throw new \Exception('This APK file has already been uploaded');
        }
        
        // Create app record
        $app = App::create([
            'name' => $data['name'] ?? $metadata['app_name'],
            'package_name' => $metadata['package_name'],
            'version_name' => $metadata['version_name'],
            'version_code' => $metadata['version_code'],
            'file_path' => $storedPath,
            'file_hash' => $fileHash,
            'file_size' => $file->getSize(),
            'channel' => $data['channel'] ?? App::CHANNEL_INTERNAL,
            'status' => App::STATUS_ACTIVE,
            'metadata' => $metadata,
            'changelog' => $data['changelog'] ?? null,
            'min_sdk_version' => $metadata['min_sdk_version'] ?? null,
            'target_sdk_version' => $metadata['target_sdk_version'] ?? null,
            'permissions' => $metadata['permissions'] ?? [],
            'uploaded_by' => auth()->id(),
            'released_at' => $data['channel'] === App::CHANNEL_STABLE ? now() : null,
        ]);
        
        return $app;
    }
    
    private function validateApkFile(UploadedFile $file): void
    {
        // Check file extension
        if ($file->getClientOriginalExtension() !== 'apk') {
            throw new \Exception('File must be an APK file');
        }
        
        // Check file size (max 100MB)
        if ($file->getSize() > 100 * 1024 * 1024) {
            throw new \Exception('APK file size cannot exceed 100MB');
        }
        
        // Check MIME type
        $allowedMimes = ['application/vnd.android.package-archive', 'application/octet-stream'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \Exception('Invalid APK file format');
        }
    }
    
    private function extractApkMetadata(UploadedFile $file): array
    {
        // This is a simplified version. In production, you'd use a proper APK parser
        // like aapt (Android Asset Packaging Tool) or a PHP library
        
        $metadata = [
            'app_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'package_name' => 'com.example.app', // Would be extracted from APK
            'version_name' => '1.0.0', // Would be extracted from APK
            'version_code' => 1, // Would be extracted from APK
            'min_sdk_version' => 21,
            'target_sdk_version' => 33,
            'permissions' => [
                'android.permission.INTERNET',
                'android.permission.READ_PHONE_STATE',
                'android.permission.CALL_PHONE',
            ],
        ];
        
        // In a real implementation, you would:
        // 1. Use aapt command line tool to extract manifest
        // 2. Parse the AndroidManifest.xml
        // 3. Extract package name, version, permissions, etc.
        
        return $metadata;
    }
    
    public function getAppVersions(string $packageName, string $channel = null): \Illuminate\Database\Eloquent\Collection
    {
        return App::where('package_name', $packageName)
                  ->when($channel, fn($q) => $q->where('channel', $channel))
                  ->orderBy('version_code', 'desc')
                  ->get();
    }
    
    public function getLatestVersion(string $packageName, string $channel): ?App
    {
        return App::where('package_name', $packageName)
                  ->where('channel', $channel)
                  ->where('status', App::STATUS_ACTIVE)
                  ->orderBy('version_code', 'desc')
                  ->first();
    }
    
    public function promoteToChannel(App $app, string $newChannel): App
    {
        // Create a copy for the new channel
        $newApp = $app->replicate();
        $newApp->channel = $newChannel;
        $newApp->released_at = $newChannel === App::CHANNEL_STABLE ? now() : null;
        $newApp->save();
        
        return $newApp;
    }
    
    public function deleteApp(App $app): bool
    {
        // Delete file from storage
        if (Storage::exists($app->file_path)) {
            Storage::delete($app->file_path);
        }
        
        // Delete database record
        return $app->delete();
    }
}