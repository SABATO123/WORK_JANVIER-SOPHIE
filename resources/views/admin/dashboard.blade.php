@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-4">Welcome, {{ auth()->user()->name }}!</h2>
    <p class="text-gray-600 mb-6">Admin Dashboard</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Bus Management Card -->
        <div class="bg-blue-100 p-6 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Manage Buses</h3>
            <p class="text-gray-600 mb-4">Add, edit, or remove buses from the system</p>
            <div class="space-y-2">
                <a href="{{ route('admin.buses.index') }}" class="block text-blue-500 hover:text-blue-700">View All Buses →</a>
                <a href="{{ route('admin.buses.create') }}" class="block text-green-500 hover:text-green-700">Add New Bus →</a>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                <p>Manage bus details including:</p>
                <ul class="list-disc list-inside mt-2">
                    <li>Bus name and type</li>
                    <li>Total seats</li>
                    <li>Operational status</li>
                </ul>
            </div>
        </div>

        <!-- Route Management Card -->
        <div class="bg-green-100 p-6 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Manage Routes</h3>
            <p class="text-gray-600 mb-4">Configure bus routes and schedules</p>
            <div class="space-y-2">
                <a href="{{ route('admin.routes.index') }}" class="block text-blue-500 hover:text-blue-700">View All Routes →</a>
                <a href="{{ route('admin.routes.create') }}" class="block text-green-500 hover:text-green-700">Add New Route →</a>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                <p>Manage route details including:</p>
                <ul class="list-disc list-inside mt-2">
                    <li>Origin and destination</li>
                    <li>Distance and duration</li>
                    <li>Fare and schedule</li>
                </ul>
            </div>
        </div>

        <!-- Booking Management Card -->
        <div class="bg-yellow-100 p-6 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Bookings</h3>
            <p class="text-gray-600 mb-4">View and manage passenger bookings</p>
            <div class="space-y-2">
                <a href="{{ route('admin.bookings.index') }}" class="block text-blue-500 hover:text-blue-700">View All Bookings →</a>
                <a href="{{ route('admin.bookings.create') }}" class="block text-green-500 hover:text-green-700">Create Booking →</a>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                <p>Booking management features:</p>
                <ul class="list-disc list-inside mt-2">
                    <li>View booking details</li>
                    <li>Modify reservations</li>
                    <li>Cancel bookings</li>
                </ul>
            </div>
        </div>

        <!-- Passenger Management Card -->
        <div class="bg-purple-100 p-6 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Manage Passengers</h3>
            <p class="text-gray-600 mb-4">View and manage passenger accounts</p>
            <div class="space-y-2">
                <a href="{{ route('admin.passengers.index') }}" class="block text-blue-500 hover:text-blue-700">View All Passengers →</a>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                <p>Passenger management features:</p>
                <ul class="list-disc list-inside mt-2">
                    <li>View passenger details</li>
                    <li>Update passenger info</li>
                    <li>Manage account status</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Quick Stats Section -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
            <h4 class="text-sm font-semibold text-gray-500">Total Buses</h4>
            <p class="text-2xl font-bold text-blue-600">{{ $totalBuses ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
            <h4 class="text-sm font-semibold text-gray-500">Active Routes</h4>
            <p class="text-2xl font-bold text-green-600">{{ $activeRoutes ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
            <h4 class="text-sm font-semibold text-gray-500">Today's Bookings</h4>
            <p class="text-2xl font-bold text-yellow-600">{{ $todayBookings ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
            <h4 class="text-sm font-semibold text-gray-500">Total Passengers</h4>
            <p class="text-2xl font-bold text-purple-600">{{ $totalPassengers ?? 0 }}</p>
        </div>
    </div>
</div>
@endsection
