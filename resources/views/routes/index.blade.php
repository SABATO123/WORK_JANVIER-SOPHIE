@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
        Available Routes / Inzira Zihari
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($routes as $route)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $route->from }} → {{ $route->to }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ date('l, F j, Y', strtotime($route->departure_time)) }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ date('h:i A', strtotime($route->departure_time)) }} - 
                                {{ date('h:i A', strtotime($route->arrival_time)) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-green-600 dark:text-green-400">
                                RWF {{ number_format($route->fare, 0) }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex justify-between items-center text-sm">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">Bus:</span> {{ $route->bus->name }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">Available Seats:</span> 
                                    {{ $route->bus->total_seats - $route->bookings()->where('status', 'confirmed')->count() }}
                                </p>
                            </div>
                            <a href="{{ route('login') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Login to Book / Injira Ugure
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500 dark:text-gray-400">
                <p>No routes available at the moment / Nta nzira zihari ubu</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $routes->links() }}
    </div>
</div>
@endsection
