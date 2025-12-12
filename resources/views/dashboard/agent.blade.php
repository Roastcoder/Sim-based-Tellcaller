@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Agent Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome back, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Assigned Leads</p>
                    <p class="text-2xl font-semibold text-gray-900">24</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Calls Today</p>
                    <p class="text-2xl font-semibold text-gray-900">12</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Call Duration</p>
                    <p class="text-2xl font-semibold text-gray-900">2h 45m</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Conversions</p>
                    <p class="text-2xl font-semibold text-gray-900">3</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Leads</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">John Doe</p>
                            <p class="text-sm text-gray-600">+1 234 567 8900</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">Jane Smith</p>
                            <p class="text-sm text-gray-600">+1 234 567 8901</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Interested</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">Mike Johnson</p>
                            <p class="text-sm text-gray-600">+1 234 567 8902</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">Follow-up</span>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('agent.leads') }}" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-center block">
                        View All Leads
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Today's Schedule</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-3 h-3 bg-blue-600 rounded-full"></div>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">Follow-up Call</p>
                            <p class="text-sm text-gray-600">10:00 AM - Sarah Wilson</p>
                        </div>
                    </div>
                    <div class="flex items-center p-4 bg-green-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">New Lead Call</p>
                            <p class="text-sm text-gray-600">2:00 PM - Robert Brown</p>
                        </div>
                    </div>
                    <div class="flex items-center p-4 bg-yellow-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-3 h-3 bg-yellow-600 rounded-full"></div>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">Team Meeting</p>
                            <p class="text-sm text-gray-600">4:00 PM - Conference Room</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection