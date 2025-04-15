@extends('layouts.app')

@section('title', 'Passenger Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-4">Welcome, {{ auth()->user()->name }}!</h2>

    <!-- Available Routes -->
    <div class="bg-blue-50 p-6 rounded-lg mb-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Available Routes</h3>
            <a href="{{ route('passenger.routes.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">View All Routes</a>
        </div>

        @if($routes->isEmpty())
            <p class="text-gray-500 text-center py-4">No routes available at the moment.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Schedule</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available Seats</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fare</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($routes->take(5) as $route)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $route->from }} → {{ $route->to }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $route->bus->name }} ({{ $route->bus->bus_number }})
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div>Departure: {{ \Carbon\Carbon::parse($route->departure_time)->format('M d, Y h:i A') }}</div>
                                    <div>Arrival: {{ \Carbon\Carbon::parse($route->arrival_time)->format('M d, Y h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    @php
                                        $bookedSeats = \App\Models\Booking::where('route_id', $route->id)
                                            ->where('status', 'confirmed')
                                            ->whereDate('travel_date', \Carbon\Carbon::parse($route->departure_time)->toDateString())
                                            ->count();
                                        $availableSeats = $route->bus->total_seats - $bookedSeats;
                                    @endphp
                                    {{ $availableSeats }} seats
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ number_format($route->fare, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($availableSeats > 0)
                                        <a href="{{ route('passenger.routes.book.form', $route->id) }}"
                                           class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm">
                                            Book Now
                                        </a>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Fully Booked
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Recent Bookings -->
    <div class="mt-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Recent Bookings</h3>
            <a href="{{ route('passenger.bookings.index') }}"
                class="text-blue-600 hover:text-blue-800 font-medium">View All</a>
        </div>

        @if($bookings->isEmpty())
            <p class="text-gray-500 text-center py-4">No recent bookings found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Travel Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $booking->route->from }} → {{ $booking->route->to }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $booking->route->bus->name }} ({{ $booking->route->bus->bus_number }})
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ date('M d, Y', strtotime($booking->travel_date)) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('passenger.bookings.show', $booking) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                    @if($booking->status === 'confirmed')
                                        <form action="{{ route('passenger.bookings.cancel', $booking) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
