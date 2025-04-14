@extends('layouts.app')

@section('content')
<div class="relative min-h-screen bg-white dark:bg-gray-900">
    <!-- Hero section with parallax effect -->
    <div class="relative h-[70vh] overflow-hidden">
        <!-- Background image with overlay -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/90 to-blue-800/90 mix-blend-multiply"></div>
            <img src="{{ asset('images/backgrounds/hero-bg.jpg') }}" 
                 alt="Modern bus on road" 
                 class="w-full h-full object-cover object-center">
        </div>
        
        <!-- Hero content -->
        <div class="relative h-full flex items-center justify-center">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 text-center text-white">
                <h1 class="text-5xl font-bold tracking-tight sm:text-6xl md:text-7xl mb-6">
                    <span class="block font-extrabold">BusCab</span>
                    <span class="block text-3xl mt-4 text-blue-200">Book Your Journey Today / Fata Urugendo Rwawe</span>
                </h1>
                <p class="max-w-md mx-auto mt-6 text-xl text-blue-100 sm:text-2xl md:mt-8 md:max-w-3xl">
                    Safe, Comfortable & Affordable Bus Travel Across Rwanda<br>
                    <span class="text-lg mt-2 block">Urugendo Rutekanye, Runoze & Rudahenze muri Rwanda</span>
                </p>
            </div>
        </div>

        <!-- Wave effect at bottom -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="w-full h-16 text-white dark:text-gray-900 fill-current" viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,32L60,37.3C120,43,240,53,360,48C480,43,600,21,720,16C840,11,960,21,1080,32C1200,43,1320,53,1380,58.7L1440,64L1440,80L1380,80C1320,80,1200,80,1080,80C960,80,840,80,720,80C600,80,480,80,360,80C240,80,120,80,60,80L0,80Z"></path>
            </svg>
        </div>
    </div>

       
        <div class="py-12 bg-white dark:bg-gray-900">
            <div class="px-4 mx-auto max-w-3xl sm:px-6">
                <div class="relative bg-gradient-to-r from-blue-600 to-blue-700 shadow-xl rounded-lg overflow-hidden">
                    <div class="relative p-8">
                        <div class="text-center">
                            <h2 class="text-2xl font-bold text-white mb-4">Ready to Start Your Journey?</h2>
                            <p class="text-blue-100 mb-6">Explore our available routes and book your next adventure today!</p>
                            <a href="{{ route('routes.index') }}" 
                               class="inline-flex items-center px-8 py-4 border-2 border-white text-lg font-medium rounded-full text-white hover:bg-white hover:text-blue-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                                View All Available Routes / Reba Inzira Zose Zihari
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="mt-16">
            <div class="px-4 mx-auto max-w-7xl sm:px-6">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="text-center">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">24/7 Service / Serivisi ya buri gihe</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Book your tickets anytime, anywhere / Gura itike igihe icyo aricyo cyose</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="text-center">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Safe Travel / Urugendo rutekanye</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Your safety is our top priority / Umutekano wawe niwo mbere</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="text-center">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Best Prices / Ibiciro byiza</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Competitive rates for all routes / Ibiciro bikwiye kuri buri nzira</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Buses Section -->
        <div class="mt-16 pb-16">
            <div class="px-4 mx-auto max-w-7xl sm:px-6">
                <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">
                    Available Buses / Bisi Zihari
                </h2>
                
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($buses as $bus)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                            <!-- Bus Image -->
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $bus->image_url }}" 
                                     alt="{{ $bus->name }}" 
                                     class="w-full h-full object-cover">
                                <div class="absolute top-0 right-0 p-2 bg-blue-600 text-white text-sm font-semibold">
                                    {{ $bus->type }}
                                </div>
                            </div>

                            <!-- Bus Details -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $bus->name }}
                                </h3>
                                <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                                    <p><span class="font-medium">Bus Number:</span> {{ $bus->bus_number }}</p>
                                    <p><span class="font-medium">Total Seats:</span> {{ $bus->total_seats }}</p>
                                </div>

                                <!-- Available Routes -->
                                <div class="mt-4">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                        Available Routes / Inzira
                                    </h4>
                                    @if($bus->routes->count() > 0)
                                        <div class="space-y-2">
                                            @foreach($bus->routes as $route)
                                                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded">
                                                    <div class="flex justify-between items-center">
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                                {{ $route->from }} → {{ $route->to }}
                                                            </p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                {{ date('h:i A', strtotime($route->departure_time)) }} - 
                                                                {{ date('h:i A', strtotime($route->arrival_time)) }}
                                                            </p>
                                                        </div>
                                                        <div class="text-right">
                                                            <p class="text-sm font-bold text-green-600 dark:text-green-400">
                                                                RWF {{ number_format($route->fare, 0) }}
                                                            </p>
                                                        </div>
                                                        <!-- Book Button -->
                                                        <div class="mt-2">
                                                            @auth
                                                                <a href="{{ route('passenger.routes.book.form', $route->id) }}" 
                                                                   class="block w-full text-center bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 transition-colors text-sm">
                                                                    Book Now / Fata Itike
                                                                </a>
                                                            @else
                                                                <a href="{{ route('login') }}" 
                                                                   class="block w-full text-center bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 transition-colors text-sm">
                                                                    Login to Book / Injira Ugure
                                                                </a>
                                                            @endauth
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            No routes available / Nta nzira zihari
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($buses->isEmpty())
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <p>No buses available at the moment / Nta bisi zihari ubu</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
