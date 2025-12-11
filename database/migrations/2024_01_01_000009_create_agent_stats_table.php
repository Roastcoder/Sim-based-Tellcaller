<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agent_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->integer('total_calls')->default(0);
            $table->integer('total_talk_seconds')->default(0);
            $table->integer('conversions')->default(0);
            $table->integer('leads_contacted')->default(0);
            $table->integer('follow_ups_scheduled')->default(0);
            $table->decimal('conversion_rate', 5, 2)->default(0);
            $table->json('hourly_breakdown')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'date']);
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_stats');
    }
};