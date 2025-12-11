<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CompanySeeder::class,
            UserSeeder::class,
            TeamSeeder::class,
            LeadSeeder::class,
            AppSeeder::class,
            DeviceSeeder::class,
            CallLogSeeder::class,
            AgentStatSeeder::class,
        ]);
    }
}