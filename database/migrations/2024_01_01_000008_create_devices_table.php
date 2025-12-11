<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('device_name')->nullable();
            $table->string('model')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('os_version')->nullable();
            $table->string('app_version')->nullable();
            $table->integer('app_version_code')->nullable();
            $table->string('ip_address')->nullable();
            $table->json('device_info')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_locked')->default(false);
            $table->timestamp('last_sync_at')->nullable();
            $table->timestamp('registered_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_active']);
            $table->index('device_id');
        });

        // Create device_app_installs pivot table
        Schema::create('device_app_installs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->onDelete('cascade');
            $table->foreignId('app_id')->constrained()->onDelete('cascade');
            $table->timestamp('installed_at');
            $table->timestamp('last_opened_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['device_id', 'app_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_app_installs');
        Schema::dropIfExists('devices');
    }
};