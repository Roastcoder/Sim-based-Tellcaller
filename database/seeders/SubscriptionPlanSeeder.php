<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'description' => 'Perfect for small teams getting started',
                'price' => 29.99,
                'billing_cycle' => 'monthly',
                'max_users' => 5,
                'max_leads' => 1000,
                'features' => ['Basic Dashboard', 'Call Logging', 'Lead Management'],
                'is_active' => true
            ],
            [
                'name' => 'Professional',
                'description' => 'Ideal for growing businesses',
                'price' => 79.99,
                'billing_cycle' => 'monthly',
                'max_users' => 25,
                'max_leads' => 10000,
                'features' => ['Advanced Analytics', 'Team Management', 'API Access', 'Priority Support'],
                'is_active' => true
            ],
            [
                'name' => 'Enterprise',
                'description' => 'For large organizations with advanced needs',
                'price' => 199.99,
                'billing_cycle' => 'monthly',
                'max_users' => 100,
                'max_leads' => 50000,
                'features' => ['Custom Integrations', 'White Label', 'Dedicated Support', 'Advanced Security'],
                'is_active' => true
            ]
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}