@extends('layouts.app')
@section('title', 'Devices')
@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold leading-7 text-gray-900">Devices</h1>
        <p class="mt-2 text-sm text-gray-700">Monitor and manage mobile devices</p>
    </div>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-12 text-center">
            <h3 class="mt-2 text-sm font-semibold text-gray-900">No devices</h3>
            <p class="mt-1 text-sm text-gray-500">Devices will appear here once agents register their mobile apps.</p>
        </div>
    </div>
</div>
@endsection