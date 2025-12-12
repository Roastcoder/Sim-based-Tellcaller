@extends('layouts.app')

@section('title', 'Call Logs')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold leading-7 text-gray-900">Call Logs</h1>
        <p class="mt-2 text-sm text-gray-700">View and manage call history</p>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
            </svg>
            <h3 class="mt-2 text-sm font-semibold text-gray-900">No call logs</h3>
            <p class="mt-1 text-sm text-gray-500">Call logs will appear here once agents start making calls.</p>
        </div>
    </div>
</div>
@endsection