<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->tinyInteger('id')->primary();
            $table->string('name', 50);
            $table->string('display_name', 100);
            $table->json('permissions')->nullable();
            $table->timestamps();
        });

        // Insert default roles
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'SUPER_ADMIN', 'display_name' => 'Super Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'ADMIN', 'display_name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'MANAGER', 'display_name' => 'Manager', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'AGENT', 'display_name' => 'Agent', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};