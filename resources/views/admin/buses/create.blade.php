@extends('layouts.app')

@section('title', 'Add New Bus')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-lg mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Add New Bus</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.buses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Bus Name</label>
                    <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name') }}" required>
                </div>

                <div class="mb-4">
                    <label for="bus_number" class="block text-gray-700 text-sm font-bold mb-2">Bus Number</label>
                    <input type="text" name="bus_number" id="bus_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('bus_number') }}" required placeholder="e.g., KA-01-HH-1234">
                </div>

                <div class="mb-4">
                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Bus Type</label>
                    <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select Type</option>
                        <option value="AC" {{ old('type') == 'AC' ? 'selected' : '' }}>AC</option>
                        <option value="Non-AC" {{ old('type') == 'Non-AC' ? 'selected' : '' }}>Non-AC</option>
                        <option value="Sleeper" {{ old('type') == 'Sleeper' ? 'selected' : '' }}>Sleeper</option>
                        <option value="Semi-Sleeper" {{ old('type') == 'Semi-Sleeper' ? 'selected' : '' }}>Semi-Sleeper</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="total_seats" class="block text-gray-700 text-sm font-bold mb-2">Total Seats</label>
                    <input type="number" name="total_seats" id="total_seats" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('total_seats') }}" required min="1">
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select Status</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="features" class="block text-gray-700 text-sm font-bold mb-2">Features</label>
                    <textarea name="features" id="features" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3" placeholder="Enter bus features (e.g., WiFi, USB Charging, etc.)">{{ old('features') }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Bus Image</label>
                    <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" accept="image/*">
                    <p class="text-sm text-gray-500 mt-1">Upload an image of the bus (JPEG, PNG, JPG, max 2MB)</p>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Add Bus
                    </button>
                    <a href="{{ route('admin.buses.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
