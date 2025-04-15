@extends('layouts.app')

@section('title', 'Search Buses')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-bold mb-4">Search Buses</h1>
            <form action="{{ route('passenger.search') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="from" class="block text-sm font-medium text-gray-700">From</label>
                        <input type="text" name="from" id="from" value="{{ request('from') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="to" class="block text-sm font-medium text-gray-700">To</label>
                        <input type="text" name="to" id="to" value="{{ request('to') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Travel Date</label>
                        <input type="date" name="date" id="date" value="{{ request('date') ?? date('Y-m-d') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Search Buses
                </button>
            </form>
        </div>

        @if(isset($routes))
            @if($routes->count() > 0)
                <div class="space-y-4">
                    @foreach($routes as $route)
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $route->bus->name }} ({{ $route->bus->bus_number }})</h3>
                                    <p class="text-gray-600">{{ $route->from }} to {{ $route->to }}</p>
                                    <p class="text-gray-600">
                                        {{ date('h:i A', strtotime($route->departure_time)) }} - 
                                        {{ date('h:i A', strtotime($route->arrival_time)) }}
                                    </p>
                                    <p class="text-gray-600">Available Seats: {{ $route->bus->total_seats - $route->bookings->sum(fn($b) => count(json_decode($b->seats))) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold">RM {{ number_format($route->fare, 2) }}</p>
                                    <a href="{{ route('passenger.book', $route) }}" class="mt-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-block">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <p class="text-gray-600">No buses found for your search criteria.</p>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
