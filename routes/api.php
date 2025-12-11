<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    LeadController,
    CallLogController,
    DeviceController,
    AppController,
    UserController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public API Routes
Route::prefix('v1')->group(function () {
    
    // Authentication
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/device-bind', [AuthController::class, 'deviceBind']);
    
    // Protected API Routes
    Route::middleware(['auth:sanctum'])->group(function () {
        
        // Auth Management
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/me', [AuthController::class, 'me']);
        Route::post('auth/refresh-token', [AuthController::class, 'refreshToken']);
        
        // Leads API
        Route::apiResource('leads', LeadController::class);
        Route::post('leads/bulk-update', [LeadController::class, 'bulkUpdate']);
        Route::get('leads/{lead}/timeline', [LeadController::class, 'timeline']);
        
        // Call Logs API
        Route::apiResource('call-logs', CallLogController::class);
        Route::post('call-logs/batch', [CallLogController::class, 'batch']);
        Route::post('call-logs/sync', [CallLogController::class, 'sync']);
        
        // Voice Notes
        Route::post('voice-upload-url', [CallLogController::class, 'getVoiceUploadUrl']);
        Route::post('voice-notes/{callLog}', [CallLogController::class, 'uploadVoiceNote']);
        
        // Device Management
        Route::get('device-status', [DeviceController::class, 'status']);
        Route::post('device-sync', [DeviceController::class, 'sync']);
        Route::get('devices', [DeviceController::class, 'index']);
        
        // Apps API
        Route::get('apps', [AppController::class, 'index']);
        Route::get('apps/latest', [AppController::class, 'latest']);
        Route::post('apps/register-install', [AppController::class, 'registerInstall']);
        Route::get('apps/{app}/download-url', [AppController::class, 'getDownloadUrl']);
        
        // User Profile
        Route::get('profile', [UserController::class, 'profile']);
        Route::patch('profile', [UserController::class, 'updateProfile']);
        
        // Agent Stats (Agent only)
        Route::middleware(['role.api:AGENT'])->group(function () {
            Route::get('my-stats', [UserController::class, 'myStats']);
            Route::get('my-leads', [LeadController::class, 'myLeads']);
            Route::get('my-calls', [CallLogController::class, 'myCalls']);
        });
        
        // Manager APIs (Manager+)
        Route::middleware(['role.api:MANAGER,ADMIN,SUPER_ADMIN'])->group(function () {
            Route::get('team-stats', [UserController::class, 'teamStats']);
            Route::post('leads/assign', [LeadController::class, 'assign']);
            Route::get('team-leads', [LeadController::class, 'teamLeads']);
            Route::get('team-agents', [UserController::class, 'teamAgents']);
        });
        
        // Admin APIs (Admin+)
        Route::middleware(['role.api:ADMIN,SUPER_ADMIN'])->group(function () {
            Route::apiResource('users', UserController::class);
            Route::get('company-stats', [UserController::class, 'companyStats']);
            Route::post('leads/import', [LeadController::class, 'import']);
            Route::get('reports/company', [UserController::class, 'companyReports']);
        });
        
        // Super Admin APIs
        Route::middleware(['role.api:SUPER_ADMIN'])->group(function () {
            Route::get('platform-stats', [UserController::class, 'platformStats']);
            Route::get('companies', [UserController::class, 'companies']);
        });
    });
});

// Webhook Routes (for external integrations)
Route::prefix('webhooks')->group(function () {
    Route::post('call-events', [CallLogController::class, 'webhook']);
    Route::post('device-events', [DeviceController::class, 'webhook']);
});

// Health Check
Route::get('health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'version' => config('app.version', '1.0.0')
    ]);
});