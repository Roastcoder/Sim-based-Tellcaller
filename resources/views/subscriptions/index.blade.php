@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Subscription Plans</h1>
        <p class="text-gray-600 mt-2">Choose the perfect plan for your business needs</p>
    </div>

    @if($userSubscription)
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-green-800">Current Plan: {{ $userSubscription->subscriptionPlan->name }}</h3>
                <p class="text-green-600">Expires on {{ $userSubscription->ends_at->format('M d, Y') }}</p>
            </div>
            <form action="{{ route('subscriptions.cancel') }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                    Cancel Subscription
                </button>
            </form>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($plans as $plan)
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                <div class="text-4xl font-bold text-blue-600 mb-4">
                    {{ $plan->formatted_price }}
                    <span class="text-lg text-gray-500">/{{ $plan->billing_cycle }}</span>
                </div>
                <p class="text-gray-600 mb-6">{{ $plan->description }}</p>
            </div>

            <div class="space-y-3 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-700">{{ $plan->max_users }} Users</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-700">{{ $plan->max_leads }} Leads</span>
                </div>
                @if($plan->features)
                    @foreach($plan->features as $feature)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">{{ $feature }}</span>
                    </div>
                    @endforeach
                @endif
            </div>

            <form action="{{ route('subscriptions.subscribe', $plan) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 font-semibold">
                    @if($userSubscription && $userSubscription->subscriptionPlan->id === $plan->id)
                        Current Plan
                    @else
                        Subscribe Now
                    @endif
                </button>
            </form>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No subscription plans</h3>
            <p class="mt-1 text-sm text-gray-500">No subscription plans are currently available.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection