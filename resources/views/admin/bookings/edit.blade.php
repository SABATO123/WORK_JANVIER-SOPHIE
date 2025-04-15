@extends('layouts.app')

@section('title', 'Edit Booking')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Edit Booking #{{ $booking->id }}</h1>
            <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Bookings</a>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Passenger</label>
                    <select name="user_id" id="user_id" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Passenger</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" 
                                {{ (old('user_id', $booking->user_id) == $user->id) ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="route_id" class="block text-sm font-medium text-gray-700">Route</label>
                    <select name="route_id" id="route_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Route</option>
                        @foreach($routes as $route)
                            <option value="{{ $route->id }}" 
                                {{ (old('route_id', $booking->route_id) == $route->id) ? 'selected' : '' }}>
                                {{ $route->from }} → {{ $route->to }} 
                                ({{ $route->bus->name }}, RWF {{ number_format($route->fare, 0) }})
                            </option>
                        @endforeach
                    </select>
                    @error('route_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="travel_date" class="block text-sm font-medium text-gray-700">Travel Date</label>
                    <input type="date" name="travel_date" id="travel_date" required
                           value="{{ old('travel_date', $booking->travel_date) }}"
                           min="{{ date('Y-m-d') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('travel_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="seat_number" class="block text-sm font-medium text-gray-700">Seat Number</label>
                    <input type="number" name="seat_number" id="seat_number" required
                           value="{{ old('seat_number', $booking->seat_number) }}"
                           min="1"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('seat_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @php
                    $passengerDetails = json_decode($booking->passenger_details, true);
                @endphp

                <div>
                    <label for="passenger_name" class="block text-sm font-medium text-gray-700">Passenger Name</label>
                    <input type="text" name="passenger_name" id="passenger_name" required
                           value="{{ old('passenger_name', $passengerDetails['name']) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('passenger_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="passenger_phone" class="block text-sm font-medium text-gray-700">Passenger Phone</label>
                    <input type="tel" name="passenger_phone" id="passenger_phone" required
                           value="{{ old('passenger_phone', $passengerDetails['phone']) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('passenger_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="confirmed" {{ (old('status', $booking->status) == 'confirmed') ? 'selected' : '' }}>
                            Confirmed
                        </option>
                        <option value="cancelled" {{ (old('status', $booking->status) == 'cancelled') ? 'selected' : '' }}>
                            Cancelled
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.bookings.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
