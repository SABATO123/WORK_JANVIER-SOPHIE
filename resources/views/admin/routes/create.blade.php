@extends('layouts.app')

@section('title', 'Create Route')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Create New Route</h1>
                    <a href="{{ route('admin.routes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back
                    </a>
                </div>

                <form action="{{ route('admin.routes.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Route Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bus_id" class="block text-sm font-medium text-gray-700">Bus</label>
                        <select name="bus_id" id="bus_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select a bus</option>
                            @foreach($buses as $bus)
                                <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>
                                    {{ $bus->name }} ({{ $bus->bus_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('bus_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="from" class="block text-sm font-medium text-gray-700">From</label>
                            <input type="text" name="from" id="from" value="{{ old('from') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('from')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="to" class="block text-sm font-medium text-gray-700">To</label>
                            <input type="text" name="to" id="to" value="{{ old('to') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('to')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="departure_time" class="block text-sm font-medium text-gray-700">Departure Time</label>
                            <input type="time" name="departure_time" id="departure_time" value="{{ old('departure_time') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('departure_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="arrival_time" class="block text-sm font-medium text-gray-700">Arrival Time</label>
                            <input type="time" name="arrival_time" id="arrival_time" value="{{ old('arrival_time') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                oninput="validateArrivalTime()">
                            @error('arrival_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="fare" class="block text-sm font-medium text-gray-700">Fare (RM)</label>
                        <input type="number" name="fare" id="fare" value="{{ old('fare') }}" step="0.01" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('fare')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create Route
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function validateArrivalTime() {
    const departureTime = document.getElementById('departure_time').value;
    const arrivalTime = document.getElementById('arrival_time').value;
    const submitButton = document.querySelector('button[type="submit"]');
    
    if (departureTime && arrivalTime) {
        if (arrivalTime <= departureTime) {
            document.getElementById('arrival_time').setCustomValidity('Arrival time must be after departure time');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            document.getElementById('arrival_time').setCustomValidity('');
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
}

document.getElementById('departure_time').addEventListener('input', validateArrivalTime);
</script>

@endsection
