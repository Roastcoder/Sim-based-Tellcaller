<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('settings')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['company_id', 'manager_id']);
        });

        // Add team_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->after('manager_id')->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });
        
        Schema::dropIfExists('teams');
    }
};