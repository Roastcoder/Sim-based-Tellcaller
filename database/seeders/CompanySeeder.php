<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::firstOrCreate(
            ['slug' => 'demo-corp'],
            [
                'name' => 'Demo Telecom Corp',
                'primary_color' => '#3B82F6',
                'billing_status' => 'active',
                'status' => true,
            ]
        );

        Company::firstOrCreate(
            ['slug' => 'sample-sales'],
            [
                'name' => 'Sample Sales Inc',
                'primary_color' => '#10B981',
                'billing_status' => 'active',
                'status' => true,
            ]
        );
    }
}