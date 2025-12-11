<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    LeadController,
    UserController,
    TeamController,
    AppController,
    DeviceController,
    CallLogController,
    SettingsController
};
use App\Http\Controllers\Admin\{
    CompanyController,
    ReportController
};
use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Auth::routes();

// Protected Routes
Route::middleware(['auth', 'company.scope'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Leads Management
    Route::middleware(['role:MANAGER,ADMIN,SUPER_ADMIN'])->group(function () {
        Route::resource('leads', LeadController::class);
        Route::post('leads/import', [LeadController::class, 'import'])->name('leads.import');
        Route::post('leads/assign', [LeadController::class, 'assign'])->name('leads.assign');
        Route::get('leads/{lead}/timeline', [LeadController::class, 'timeline'])->name('leads.timeline');
    });
    
    // Agent Routes
    Route::middleware(['role:AGENT'])->prefix('agent')->name('agent.')->group(function () {
        Route::get('leads', [AgentDashboardController::class, 'leads'])->name('leads');
        Route::get('calls', [AgentDashboardController::class, 'calls'])->name('calls');
        Route::get('stats', [AgentDashboardController::class, 'stats'])->name('stats');
    });
    
    // Call Logs
    Route::resource('call-logs', CallLogController::class)->only(['index', 'show']);
    
    // Users Management (Admin+)
    Route::middleware(['role:ADMIN,SUPER_ADMIN'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::post('users/invite', [UserController::class, 'invite'])->name('users.invite');
    });
    
    // Teams Management (Admin+)
    Route::middleware(['role:ADMIN,SUPER_ADMIN'])->group(function () {
        Route::resource('teams', TeamController::class);
        Route::post('teams/{team}/add-agent', [TeamController::class, 'addAgent'])->name('teams.add-agent');
        Route::delete('teams/{team}/remove-agent/{user}', [TeamController::class, 'removeAgent'])->name('teams.remove-agent');
    });
    
    // Apps Management
    Route::resource('apps', AppController::class);
    Route::get('apps/{app}/download', [AppController::class, 'download'])->name('apps.download');
    Route::get('apps-upload', [AppController::class, 'upload'])->name('apps.upload');
    Route::post('apps/bulk-action', [AppController::class, 'bulkAction'])->name('apps.bulk-action');
    Route::get('apps/{app}/analytics', [AppController::class, 'analytics'])->name('apps.analytics');
    
    // Devices Management
    Route::resource('devices', DeviceController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::post('devices/{device}/lock', [DeviceController::class, 'lock'])->name('devices.lock');
    Route::post('devices/{device}/unlock', [DeviceController::class, 'unlock'])->name('devices.unlock');
    Route::post('devices/bulk-action', [DeviceController::class, 'bulkAction'])->name('devices.bulk-action');
    
    // Settings
    Route::middleware(['role:ADMIN,SUPER_ADMIN'])->group(function () {
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
    });
    
    // Super Admin Only Routes
    Route::middleware(['role:SUPER_ADMIN'])->group(function () {
        Route::resource('companies', CompanyController::class);
        Route::post('companies/{company}/toggle-status', [CompanyController::class, 'toggleStatus'])->name('companies.toggle-status');
        
        // Platform Reports
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
            Route::get('reports/companies', [ReportController::class, 'companies'])->name('reports.companies');
            Route::get('reports/users', [ReportController::class, 'users'])->name('reports.users');
            Route::get('reports/activity', [ReportController::class, 'activity'])->name('reports.activity');
        });
    });
    
    // Profile Routes
    Route::get('profile', [UserController::class, 'profile'])->name('profile.edit');
    Route::patch('profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::delete('profile', [UserController::class, 'destroy'])->name('profile.destroy');
});

// Public Download Routes (with token authentication)
Route::get('public/apps/{app}/download/{token}', [AppController::class, 'publicDownload'])->name('apps.public-download');