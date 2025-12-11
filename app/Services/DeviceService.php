<?php

namespace App\Services;

use App\Models\{Device, User, App, DeviceAppInstall};
use Illuminate\Support\Facades\DB;

class DeviceService
{
    public function registerDevice(User $user, array $deviceInfo): Device
    {
        return DB::transaction(function () use ($user, $deviceInfo) {
            $device = Device::updateOrCreate(
                ['device_id' => $deviceInfo['device_id']],
                [
                    'user_id' => $user->id,
                    'device_name' => $deviceInfo['device_name'] ?? null,
                    'model' => $deviceInfo['model'] ?? null,
                    'manufacturer' => $deviceInfo['manufacturer'] ?? null,
                    'os_version' => $deviceInfo['os_version'] ?? null,
                    'app_version' => $deviceInfo['app_version'] ?? null,
                    'app_version_code' => $deviceInfo['app_version_code'] ?? null,
                    'ip_address' => request()->ip(),
                    'device_info' => $deviceInfo,
                    'is_active' => true,
                    'last_sync_at' => now(),
                    'registered_at' => now(),
                ]
            );

            // Log device registration
            $device->logActivity('registered');

            return $device;
        });
    }

    public function bindDevice(User $user, array $deviceData): Device
    {
        // Check if device is already bound to another user
        $existingDevice = Device::where('device_id', $deviceData['device_id'])
                               ->where('user_id', '!=', $user->id)
                               ->where('is_active', true)
                               ->first();

        if ($existingDevice) {
            throw new \Exception('Device is already bound to another user');
        }

        // Check user's device limit (agents can have max 2 devices)
        if ($user->isAgent()) {
            $deviceCount = $user->devices()->where('is_active', true)->count();
            if ($deviceCount >= 2) {
                throw new \Exception('Maximum device limit reached');
            }
        }

        return $this->registerDevice($user, $deviceData);
    }

    public function syncDevice(Device $device, array $syncData): Device
    {
        $device->update([
            'app_version' => $syncData['app_version'] ?? $device->app_version,
            'app_version_code' => $syncData['app_version_code'] ?? $device->app_version_code,
            'ip_address' => request()->ip(),
            'last_sync_at' => now(),
        ]);

        // Update device info if provided
        if (isset($syncData['device_info'])) {
            $device->update([
                'device_info' => array_merge($device->device_info ?? [], $syncData['device_info'])
            ]);
        }

        return $device;
    }

    public function lockDevice(Device $device, string $reason = null): Device
    {
        $device->update([
            'is_locked' => true,
            'device_info' => array_merge($device->device_info ?? [], [
                'lock_reason' => $reason,
                'locked_at' => now()->toISOString(),
                'locked_by' => auth()->id(),
            ])
        ]);

        // Revoke all tokens for this device's user
        $device->user->tokens()->delete();

        $device->logActivity('locked', [], ['reason' => $reason]);

        return $device;
    }

    public function unlockDevice(Device $device): Device
    {
        $device->update([
            'is_locked' => false,
            'device_info' => array_merge($device->device_info ?? [], [
                'unlocked_at' => now()->toISOString(),
                'unlocked_by' => auth()->id(),
            ])
        ]);

        $device->logActivity('unlocked');

        return $device;
    }

    public function deactivateDevice(Device $device): Device
    {
        $device->update(['is_active' => false]);
        
        // Revoke tokens
        $device->user->tokens()->delete();
        
        $device->logActivity('deactivated');

        return $device;
    }

    public function recordAppInstall(Device $device, App $app): DeviceAppInstall
    {
        return DeviceAppInstall::updateOrCreate(
            [
                'device_id' => $device->id,
                'app_id' => $app->id,
            ],
            [
                'installed_at' => now(),
                'is_active' => true,
            ]
        );
    }

    public function getDeviceStats(Device $device): array
    {
        return [
            'total_apps' => $device->deviceInstalls()->count(),
            'active_apps' => $device->deviceInstalls()->where('is_active', true)->count(),
            'last_sync' => $device->last_sync_at?->diffForHumans(),
            'uptime_days' => $device->registered_at?->diffInDays(now()),
            'call_logs_count' => $device->user->callLogs()
                                            ->where('device_call_id', 'like', $device->device_id . '%')
                                            ->count(),
        ];
    }

    public function getOutdatedDevices(int $days = 7): \Illuminate\Database\Eloquent\Collection
    {
        return Device::where('is_active', true)
                    ->where('last_sync_at', '<', now()->subDays($days))
                    ->with(['user', 'deviceInstalls.app'])
                    ->get();
    }

    public function getDevicesNeedingUpdate(string $packageName, int $minVersionCode): \Illuminate\Database\Eloquent\Collection
    {
        return Device::where('is_active', true)
                    ->where('app_version_code', '<', $minVersionCode)
                    ->whereHas('deviceInstalls.app', function ($q) use ($packageName) {
                        $q->where('package_name', $packageName);
                    })
                    ->with(['user', 'deviceInstalls.app'])
                    ->get();
    }

    public function bulkAction(array $deviceIds, string $action, array $params = []): array
    {
        $devices = Device::whereIn('id', $deviceIds)->get();
        $results = [];

        foreach ($devices as $device) {
            try {
                switch ($action) {
                    case 'lock':
                        $this->lockDevice($device, $params['reason'] ?? null);
                        $results[$device->id] = 'success';
                        break;
                    case 'unlock':
                        $this->unlockDevice($device);
                        $results[$device->id] = 'success';
                        break;
                    case 'deactivate':
                        $this->deactivateDevice($device);
                        $results[$device->id] = 'success';
                        break;
                    default:
                        $results[$device->id] = 'invalid_action';
                }
            } catch (\Exception $e) {
                $results[$device->id] = 'error: ' . $e->getMessage();
            }
        }

        return $results;
    }
}