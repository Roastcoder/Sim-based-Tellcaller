@extends('layouts.app')

@section('title', 'Apps Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Apps Management
            </h1>
            <p class="mt-2 text-sm text-gray-700">
                Manage mobile application versions, uploads, and device installations
            </p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            @can('create', App\Models\App::class)
            <a href="{{ route('apps.upload') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                Upload App
            </a>
            @endcan
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Total Apps</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $stats['total_apps'] }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Active Apps</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $stats['active_apps'] }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Total Installs</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $stats['total_installs'] }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Channels</dt>
            <dd class="mt-1 text-sm text-gray-900">
                @foreach($stats['channels'] as $channel => $count)
                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $channel === 'stable' ? 'bg-green-50 text-green-700 ring-green-600/20' : ($channel === 'beta' ? 'bg-yellow-50 text-yellow-800 ring-yellow-600/20' : 'bg-blue-50 text-blue-700 ring-blue-700/10') }}">
                    {{ ucfirst($channel) }}: {{ $count }}
                </span>
                @endforeach
            </dd>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="App name or package..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="channel" class="block text-sm font-medium text-gray-700">Channel</label>
                    <select name="channel" id="channel" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Channels</option>
                        <option value="internal" {{ request('channel') === 'internal' ? 'selected' : '' }}>Internal</option>
                        <option value="beta" {{ request('channel') === 'beta' ? 'selected' : '' }}>Beta</option>
                        <option value="stable" {{ request('channel') === 'stable' ? 'selected' : '' }}>Stable</option>
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="deprecated" {{ request('status') === 'deprecated' ? 'selected' : '' }}>Deprecated</option>
                        <option value="disabled" {{ request('status') === 'disabled' ? 'selected' : '' }}>Disabled</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Apps List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul role="list" class="divide-y divide-gray-200">
            @forelse($apps as $app)
            <li>
                <div class="px-4 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900">{{ $app->name }}</div>
                                <span class="ml-2 inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $app->channel_color }}">
                                    {{ ucfirst($app->channel) }}
                                </span>
                                <span class="ml-2 inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $app->status_color }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $app->package_name }} • v{{ $app->version_name }} ({{ $app->version_code }})
                            </div>
                            <div class="text-xs text-gray-400">
                                {{ $app->file_size_human }} • {{ $app->total_installs }} installs • Uploaded {{ $app->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @can('view', $app)
                        <a href="{{ route('apps.show', $app) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            View
                        </a>
                        @endcan
                        @can('download', $app)
                        <a href="{{ route('apps.download', $app) }}" class="text-green-600 hover:text-green-900 text-sm font-medium">
                            Download
                        </a>
                        @endcan
                        @can('update', $app)
                        <a href="{{ route('apps.edit', $app) }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                            Edit
                        </a>
                        @endcan
                    </div>
                </div>
            </li>
            @empty
            <li class="px-4 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No apps</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by uploading your first mobile app.</p>
                @can('create', App\Models\App::class)
                <div class="mt-6">
                    <a href="{{ route('apps.upload') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        Upload App
                    </a>
                </div>
                @endcan
            </li>
            @endforelse
        </ul>
    </div>

    <!-- Pagination -->
    @if($apps->hasPages())
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        {{ $apps->links() }}
    </div>
    @endif
</div>
@endsection