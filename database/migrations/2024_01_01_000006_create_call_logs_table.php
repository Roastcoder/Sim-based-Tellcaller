<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('call_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lead_id')->nullable()->constrained()->onDelete('set null');
            $table->string('phone', 20);
            $table->enum('call_type', ['incoming', 'outgoing', 'missed'])->default('outgoing');
            $table->integer('duration_seconds')->default(0);
            $table->datetime('start_time');
            $table->datetime('end_time')->nullable();
            $table->string('disposition', 100)->nullable();
            $table->text('note')->nullable();
            $table->string('voice_note_path')->nullable();
            $table->string('device_call_id')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'device_call_id']);
            $table->index(['user_id', 'start_time']);
            $table->index(['lead_id', 'start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('call_logs');
    }
};