<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('package_name')->unique();
            $table->string('version_name');
            $table->integer('version_code');
            $table->string('file_path');
            $table->string('file_hash');
            $table->bigInteger('file_size');
            $table->enum('channel', ['internal', 'beta', 'stable'])->default('internal');
            $table->enum('status', ['active', 'deprecated', 'disabled'])->default('active');
            $table->json('metadata')->nullable();
            $table->text('changelog')->nullable();
            $table->integer('min_sdk_version')->nullable();
            $table->integer('target_sdk_version')->nullable();
            $table->json('permissions')->nullable();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamp('released_at')->nullable();
            $table->timestamps();

            $table->index(['package_name', 'version_code']);
            $table->index(['channel', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apps');
    }
};