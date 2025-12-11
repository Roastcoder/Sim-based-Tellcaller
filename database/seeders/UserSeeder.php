<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Company};

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'Platform Admin',
            'email' => 'admin@platform.com',
            'password' => Hash::make('password123'),
            'role_id' => User::SUPER_ADMIN,
            'company_id' => null,
            'status' => true,
            'email_verified_at' => now(),
        ]);

        // Get demo companies
        $demoCompany = Company::where('slug', 'demo-corp')->first();
        $sampleCompany = Company::where('slug', 'sample-sales')->first();

        // Create Company Admins
        User::create([
            'name' => 'John Admin',
            'email' => 'john@democorp.com',
            'password' => Hash::make('password123'),
            'role_id' => User::ADMIN,
            'company_id' => $demoCompany->id,
            'status' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Sarah Admin',
            'email' => 'sarah@samplesales.com',
            'password' => Hash::make('password123'),
            'role_id' => User::ADMIN,
            'company_id' => $sampleCompany->id,
            'status' => true,
            'email_verified_at' => now(),
        ]);

        // Create Managers for Demo Corp
        $manager1 = User::create([
            'name' => 'Mike Manager',
            'email' => 'mike@democorp.com',
            'password' => Hash::make('password123'),
            'role_id' => User::MANAGER,
            'company_id' => $demoCompany->id,
            'status' => true,
            'email_verified_at' => now(),
        ]);

        $manager2 = User::create([
            'name' => 'Lisa Manager',
            'email' => 'lisa@democorp.com',
            'password' => Hash::make('password123'),
            'role_id' => User::MANAGER,
            'company_id' => $demoCompany->id,
            'status' => true,
            'email_verified_at' => now(),
        ]);

        // Create Agents for Demo Corp
        $agents = [
            ['name' => 'Agent Smith', 'email' => 'smith@democorp.com', 'manager_id' => $manager1->id],
            ['name' => 'Agent Jones', 'email' => 'jones@democorp.com', 'manager_id' => $manager1->id],
            ['name' => 'Agent Brown', 'email' => 'brown@democorp.com', 'manager_id' => $manager2->id],
            ['name' => 'Agent Davis', 'email' => 'davis@democorp.com', 'manager_id' => $manager2->id],
            ['name' => 'Agent Wilson', 'email' => 'wilson@democorp.com', 'manager_id' => $manager1->id],
            ['name' => 'Agent Taylor', 'email' => 'taylor@democorp.com', 'manager_id' => $manager2->id],
        ];

        foreach ($agents as $agentData) {
            User::create([
                'name' => $agentData['name'],
                'email' => $agentData['email'],
                'password' => Hash::make('password123'),
                'role_id' => User::AGENT,
                'company_id' => $demoCompany->id,
                'manager_id' => $agentData['manager_id'],
                'status' => true,
                'email_verified_at' => now(),
            ]);
        }

        // Create some agents for Sample Sales
        $sampleManager = User::create([
            'name' => 'Tom Manager',
            'email' => 'tom@samplesales.com',
            'password' => Hash::make('password123'),
            'role_id' => User::MANAGER,
            'company_id' => $sampleCompany->id,
            'status' => true,
            'email_verified_at' => now(),
        ]);

        $sampleAgents = [
            ['name' => 'Alice Agent', 'email' => 'alice@samplesales.com'],
            ['name' => 'Bob Agent', 'email' => 'bob@samplesales.com'],
            ['name' => 'Carol Agent', 'email' => 'carol@samplesales.com'],
        ];

        foreach ($sampleAgents as $agentData) {
            User::create([
                'name' => $agentData['name'],
                'email' => $agentData['email'],
                'password' => Hash::make('password123'),
                'role_id' => User::AGENT,
                'company_id' => $sampleCompany->id,
                'manager_id' => $sampleManager->id,
                'status' => true,
                'email_verified_at' => now(),
            ]);
        }
    }
}