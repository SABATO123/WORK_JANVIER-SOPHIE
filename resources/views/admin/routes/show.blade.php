@extends('layouts.app')

@section('title', 'Route Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Route Details</h1>
                    <div class="space-x-2">
                        <a href="{{ route('admin.routes.edit', $route) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <a href="{{ route('admin.routes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </a>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Route Name</h3>
                        <p class="mt-1 text-lg">{{ $route->name }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Bus Details</h3>
                        <div class="mt-1">
                            <p class="text-lg">{{ $route->bus->name }}</p>
                            <p class="text-sm text-gray-600">Bus Number: {{ $route->bus->bus_number }}</p>
                            <p class="text-sm text-gray-600">Type: {{ $route->bus->type }}</p>
                            <p class="text-sm text-gray-600">Total Seats: {{ $route->bus->total_seats }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">From</h3>
                            <p class="mt-1 text-lg">{{ $route->from }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500">To</h3>
                            <p class="mt-1 text-lg">{{ $route->to }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Departure Time</h3>
                            <p class="mt-1 text-lg">{{ date('h:i A', strtotime($route->departure_time)) }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Arrival Time</h3>
                            <p class="mt-1 text-lg">{{ date('h:i A', strtotime($route->arrival_time)) }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Fare</h3>
                        <p class="mt-1 text-lg">RM {{ number_format($route->fare, 2) }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                            {{ $route->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($route->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
