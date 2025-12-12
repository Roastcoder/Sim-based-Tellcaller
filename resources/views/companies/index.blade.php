@extends('layouts.app')
@section('title', 'Companies')
@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold leading-7 text-gray-900">Companies</h1>
            <p class="mt-2 text-sm text-gray-700">Manage companies on the platform</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0">
            <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Add Company</button>
        </div>
    </div>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-12 text-center">
            <h3 class="mt-2 text-sm font-semibold text-gray-900">No companies</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by adding your first company.</p>
        </div>
    </div>
</div>
@endsection