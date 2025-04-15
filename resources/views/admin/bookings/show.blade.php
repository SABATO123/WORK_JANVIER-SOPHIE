@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Booking #{{ $booking->id }}</h1>
            <div class="space-x-4">
                <a href="{{ route('admin.bookings.edit', $booking) }}" 
                   class="text-indigo-600 hover:text-indigo-800">Edit Booking</a>
                <a href="{{ route('admin.bookings.index') }}" 
                   class="text-blue-600 hover:text-blue-800">← Back to Bookings</a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-6">
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @if($booking->status === 'confirmed') bg-green-100 text-green-800
                    @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ ucfirst($booking->status) }}
                </span> 
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Bus Details</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            <p class="text-gray-600">
                                <span class="font-medium">Bus Name:</span><br>
                                {{ $booking->route->bus->name }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Bus Number:</span><br>
                                {{ $booking->route->bus->bus_number }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Type:</span><br>
                                {{ $booking->route->bus->type }}
                            </p>
                        </div> 
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-3">Journey Details</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            <p class="text-gray-600">
                                <span class="font-medium">From:</span><br>
                                {{ $booking->route->from }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">To:</span><br>
                                {{ $booking->route->to }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Travel Date:</span><br>
                                {{ date('D, M d, Y', strtotime($booking->travel_date)) }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Departure Time:</span><br>
                                {{ date('h:i A', strtotime($booking->route->departure_time)) }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Arrival Time:</span><br>
                                {{ date('h:i A', strtotime($booking->route->arrival_time)) }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-3">User Details</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            <p class="text-gray-600">
                                <span class="font-medium">Name:</span><br>
                                {{ $booking->user->name }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Email:</span><br>
                                {{ $booking->user->email }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-3">Passenger Details</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            @php
                                $passengerDetails = json_decode($booking->passenger_details, true);
                            @endphp
                            <p class="text-gray-600">
                                <span class="font-medium">Name:</span><br>
                                {{ $passengerDetails['name'] }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Phone:</span><br>
                                {{ $passengerDetails['phone'] }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Seat Number:</span><br>
                                {{ $booking->seat_number }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-3">Payment Details</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-2xl font-bold text-green-600">
                                RWF {{ number_format($booking->total_amount, 0) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t">
                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="flex justify-end">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                            onclick="return confirm('Are you sure you want to delete this booking? This action cannot be undone.')">
                        Delete Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
