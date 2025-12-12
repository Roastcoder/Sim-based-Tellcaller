@extends('layouts.app')
@section('title', 'My Leads')
@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold leading-7 text-gray-900">My Leads</h1>
        <p class="mt-2 text-sm text-gray-700">View and manage your assigned leads</p>
    </div>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-12 text-center">
            <h3 class="mt-2 text-sm font-semibold text-gray-900">No leads assigned</h3>
            <p class="mt-1 text-sm text-gray-500">Your assigned leads will appear here.</p>
        </div>
    </div>
</div>
@endsection