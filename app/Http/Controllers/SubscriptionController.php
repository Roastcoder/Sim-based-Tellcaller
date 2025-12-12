<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();
        $userSubscription = auth()->user()->activeSubscription();
        
        return view('subscriptions.index', compact('plans', 'userSubscription'));
    }

    public function subscribe(Request $request, SubscriptionPlan $plan)
    {
        $user = auth()->user();
        
        // Cancel existing subscription
        $user->subscriptions()->where('status', 'active')->update(['status' => 'cancelled']);
        
        // Create new subscription
        UserSubscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'starts_at' => now(),
            'ends_at' => $plan->billing_cycle === 'yearly' ? now()->addYear() : now()->addMonth(),
            'status' => 'active'
        ]);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription activated successfully!');
    }

    public function cancel()
    {
        auth()->user()->subscriptions()
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription cancelled successfully!');
    }
}