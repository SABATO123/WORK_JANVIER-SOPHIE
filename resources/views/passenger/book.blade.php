@extends('layouts.app')

@section('title', 'Book Bus')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4">Book Bus</h1>
            
            <div class="mb-6 p-4 bg-gray-100 rounded-lg">
                <h3 class="font-semibold">{{ $route->bus->name }} ({{ $route->bus->bus_number }})</h3>
                <p>{{ $route->from }} to {{ $route->to }}</p>
                <p>{{ date('h:i A', strtotime($route->departure_time)) }} - {{ date('h:i A', strtotime($route->arrival_time)) }}</p>
                <p class="font-bold">Fare: RM {{ number_format($route->fare, 2) }}</p>
            </div>
            
            <form action="{{ route('passenger.book.store') }}" method="POST">
                @csrf
                <input type="hidden" name="route_id" value="{{ $route->id }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="passenger_name" class="block text-sm font-medium text-gray-700">Passenger Name</label>
                        <input type="text" name="passenger_name" id="passenger_name" required
                            value="{{ auth()->user()->name }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="passenger_phone" class="block text-sm font-medium text-gray-700">Passenger Phone</label>
                        <input type="text" name="passenger_phone" id="passenger_phone" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Seats</label>
                    <div class="grid grid-cols-5 gap-2">
                        @php
                            $bookedSeats = $route->bookings->flatMap(fn($b) => json_decode($b->seats));
                        @endphp
                        
                        @for($i = 1; $i <= $route->bus->total_seats; $i++)
                            <div>
                                <input type="checkbox" name="seats[]" id="seat-{{ $i }}" value="{{ $i }}"
                                    {{ $bookedSeats->contains($i) ? 'disabled' : '' }}
                                    class="hidden peer">
                                <label for="seat-{{ $i }}" 
                                    class="inline-flex items-center justify-center w-full h-10 rounded border-2 border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-100 peer-disabled:bg-gray-200 peer-disabled:cursor-not-allowed">
                                    {{ $i }}
                                </label>
                            </div>
                        @endfor
                    </div>
                </div>
                
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
