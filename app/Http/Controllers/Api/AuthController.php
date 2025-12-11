<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Validator};
use App\Models\{User, Device};
use App\Services\DeviceService;

class AuthController extends Controller
{
    protected $deviceService;

    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'device_info' => 'sometimes|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        // Check if user is active and company is active
        if (!$user->status || !$user->company?->isActive()) {
            Auth::logout();
            return response()->json([
                'status' => 'error',
                'message' => 'Account is inactive'
            ], 403);
        }

        // Update last login
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip()
        ]);

        // Create API token
        $token = $user->createToken('mobile-app', ['mobile'])->plainTextToken;

        // Handle device registration if provided
        $device = null;
        if ($request->has('device_info')) {
            $device = $this->deviceService->registerDevice($user, $request->device_info);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_id' => $user->role_id,
                    'role_name' => $user->role_name,
                    'company_id' => $user->company_id,
                    'team_id' => $user->team_id,
                ],
                'token' => $token,
                'device' => $device,
                'permissions' => $this->getUserPermissions($user),
            ]
        ]);
    }

    public function deviceBind(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'device_name' => 'required|string',
            'model' => 'required|string',
            'manufacturer' => 'required|string',
            'os_version' => 'required|string',
            'app_version' => 'required|string',
            'app_version_code' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        
        try {
            $device = $this->deviceService->bindDevice($user, $request->all());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Device bound successfully',
                'data' => ['device' => $device]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        
        // Revoke current token
        $request->user()->currentAccessToken()->delete();
        
        // Update device status if device_id provided
        if ($request->has('device_id')) {
            Device::where('device_id', $request->device_id)
                  ->where('user_id', $user->id)
                  ->update(['is_active' => false]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role_id' => $user->role_id,
                    'role_name' => $user->role_name,
                    'company_id' => $user->company_id,
                    'team_id' => $user->team_id,
                    'avatar' => $user->avatar,
                ],
                'permissions' => $this->getUserPermissions($user),
            ]
        ]);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        
        // Revoke current token
        $request->user()->currentAccessToken()->delete();
        
        // Create new token
        $token = $user->createToken('mobile-app', ['mobile'])->plainTextToken;
        
        return response()->json([
            'status' => 'success',
            'data' => ['token' => $token]
        ]);
    }

    private function getUserPermissions(User $user): array
    {
        $permissions = [];
        
        switch ($user->role_id) {
            case User::SUPER_ADMIN:
                $permissions = ['*'];
                break;
            case User::ADMIN:
                $permissions = [
                    'leads.view.company',
                    'leads.create',
                    'leads.assign',
                    'users.manage.company',
                    'reports.view.company',
                    'call_logs.view.company'
                ];
                break;
            case User::MANAGER:
                $permissions = [
                    'leads.view.team',
                    'leads.assign.team',
                    'users.manage.team',
                    'reports.view.team',
                    'call_logs.view.team'
                ];
                break;
            case User::AGENT:
                $permissions = [
                    'leads.view.assigned',
                    'leads.update.assigned',
                    'call_logs.create',
                    'call_logs.view.own',
                    'reports.view.own'
                ];
                break;
        }
        
        return $permissions;
    }
}