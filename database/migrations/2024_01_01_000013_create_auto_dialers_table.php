<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auto_dialers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('device_name');
            $table->string('sim_number');
            $table->string('android_device_id');
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->json('call_dispositions')->nullable();
            $table->integer('calls_made_today')->default(0);
            $table->timestamp('last_call_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auto_dialers');
    }
};