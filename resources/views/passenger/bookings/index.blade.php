@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Bookings</h1>
        <a href="{{ route('passenger.dashboard') }}" class="text-blue-600 hover:text-blue-800">← Back to Dashboard</a>
    </div>
    
    @if($bookings->count() > 0)
        <div class="space-y-4">
            @foreach($bookings as $booking)
                <div class="bg-white shadow-md rounded-lg p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold">Booking #{{ $booking->id }}</h3>
                            <div class="mt-2 space-y-2">
                                <p class="text-gray-600">
                                    <span class="font-medium">Bus:</span> 
                                    {{ $booking->route->bus->name }} ({{ $booking->route->bus->bus_number }})
                                </p>
                                <p class="text-gray-600">
                                    <span class="font-medium">Route:</span> 
                                    {{ $booking->route->from }} → {{ $booking->route->to }}
                                </p>
                                <p class="text-gray-600">
                                    <span class="font-medium">Travel Date:</span> 
                                    {{ date('M d, Y', strtotime($booking->travel_date)) }}
                                </p>
                                <p class="text-gray-600">
                                    <span class="font-medium">Departure:</span> 
                                    {{ date('h:i A', strtotime($booking->route->departure_time)) }}
                                </p>
                                <p class="text-gray-600">
                                    <span class="font-medium">Seat Number:</span> 
                                    {{ $booking->seat_number }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-green-600">RWF {{ number_format($booking->total_amount, 0) }}</p>
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                            <div class="mt-4 space-y-2">
                                <a href="{{ route('passenger.bookings.show', $booking) }}"
                                    class="block text-blue-600 hover:text-blue-800">
                                    View Details →
                                </a>
                                @if($booking->status === 'confirmed')
                                    <form action="{{ route('passenger.bookings.cancel', $booking) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-800"
                                            onclick="return confirm('Are you sure you want to cancel this booking?')">
                                            Cancel Booking
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $bookings->links() }}
            </div>
        </div>
    @else
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <p class="text-gray-600 mb-4">You haven't made any bookings yet.</p>
            <a href="{{ route('passenger.dashboard') }}" 
                class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Search for Buses
            </a>
        </div>
    @endif
</div>
@endsection
