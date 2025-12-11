<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->string('source', 100)->nullable();
            $table->enum('status', ['new', 'contacted', 'interested', 'follow_up', 'converted', 'lost'])->default('new');
            $table->string('disposition', 100)->nullable();
            $table->integer('score')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->json('custom_fields')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamp('follow_up_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            $table->index(['company_id', 'status']);
            $table->index(['assigned_to', 'status']);
            $table->index(['team_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};