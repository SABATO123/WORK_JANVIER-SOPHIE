@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Available Buses</h2>
        <a href="{{ route('passenger.dashboard') }}" class="text-blue-600 hover:text-blue-800">← Back to Dashboard</a>
    </div>

    @if($routes->isEmpty())
        <div class="text-center py-8">
            <p class="text-gray-500 text-lg">No buses found for your search criteria.</p>
            <a href="{{ route('passenger.dashboard') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800">Try another search</a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6">
            @foreach($routes as $route)
                <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <div class="flex flex-col md:flex-row justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-4">
                                <h3 class="text-xl font-semibold">{{ $route->bus->name }}</h3>
                                <span class="ml-3 px-2 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                    {{ $route->bus->type }}
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">From</p>
                                    <p class="font-medium">{{ $route->from }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ date('h:i A', strtotime($route->departure_time)) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">To</p>
                                    <p class="font-medium">{{ $route->to }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ date('h:i A', strtotime($route->arrival_time)) }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <div>
                                    <i class="fas fa-bus"></i>
                                    <span>Bus No: {{ $route->bus->bus_number }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-chair"></i>
                                    <span>{{ $route->bus->total_seats }} Seats</span>
                                </div>
                            </div>
                        </div>

                        <div class="md:ml-6 mt-4 md:mt-0 flex flex-col justify-between items-end">
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Fare</p>
                                <p class="text-2xl font-bold text-green-600">RWF {{ number_format($route->fare, 0) }}</p>
                            </div>

                            <button type="button" onclick="openBookingModal('{{ $route->id }}')"
                                class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Book Your Ticket</h3>
            <form id="bookingForm" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="travel_date" value="{{ request('travel_date') }}">
                
                <div>
                    <label for="passenger_name" class="block text-sm font-medium text-gray-700">Passenger Name</label>
                    <input type="text" name="passenger_name" id="passenger_name" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="passenger_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" name="passenger_phone" id="passenger_phone" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="seat_number" class="block text-sm font-medium text-gray-700">Seat Number</label>
                    <input type="number" name="seat_number" id="seat_number" required min="1"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeBookingModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openBookingModal(routeId) {
    const modal = document.getElementById('bookingModal');
    const form = document.getElementById('bookingForm');
    form.action = '{{ url("/passenger/routes") }}/' + routeId + '/book';
    
    // Reset form
    form.reset();
    
    // Show modal
    modal.classList.remove('hidden');
}

function closeBookingModal() {
    const modal = document.getElementById('bookingModal');
    const form = document.getElementById('bookingForm');
    form.reset();
    modal.classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('bookingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBookingModal();
    }
});

// Handle form submission
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.innerHTML = 'Processing...';
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            passenger_name: document.getElementById('passenger_name').value,
            passenger_phone: document.getElementById('passenger_phone').value,
            seat_number: document.getElementById('seat_number').value,
            travel_date: document.querySelector('input[name="travel_date"]').value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert(data.message || 'An error occurred while booking the ticket.');
            submitButton.disabled = false;
            submitButton.innerHTML = 'Confirm Booking';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while booking the ticket.');
        submitButton.disabled = false;
        submitButton.innerHTML = 'Confirm Booking';
    });
});
</script>
@endpush
