@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Book Ticket</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Route Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>From:</strong> {{ $route->from }}</p>
                                <p><strong>To:</strong> {{ $route->to }}</p>
                                <p><strong>Bus:</strong> {{ $route->bus->name }} ({{ $route->bus->bus_number }})</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Departure:</strong> {{ \Carbon\Carbon::parse($route->departure_time)->format('M d, Y h:i A') }}</p>
                                <p><strong>Arrival:</strong> {{ \Carbon\Carbon::parse($route->arrival_time)->format('M d, Y h:i A') }}</p>
                                <p><strong>Fare:</strong> {{ number_format($route->fare, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('passenger.routes.book', $route->id) }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="travel_date" value="{{ \Carbon\Carbon::parse($route->departure_time)->toDateString() }}">
                        
                        <div class="mb-3">
                            <label for="passenger_name" class="form-label">Passenger Name</label>
                            <input type="text" class="form-control @error('passenger_name') is-invalid @enderror" 
                                   id="passenger_name" name="passenger_name" value="{{ old('passenger_name', auth()->user()->name) }}" required>
                            @error('passenger_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="passenger_phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control @error('passenger_phone') is-invalid @enderror" 
                                   id="passenger_phone" name="passenger_phone" value="{{ old('passenger_phone') }}" required>
                            @error('passenger_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="seat_number" class="form-label">Select Seat</label>
                            <select class="form-control @error('seat_number') is-invalid @enderror" 
                                    id="seat_number" name="seat_number" required>
                                <option value="">Choose a seat</option>
                                @for($i = 1; $i <= $route->bus->total_seats; $i++)
                                    @if(!in_array($i, $bookedSeats))
                                        <option value="{{ $i }}" {{ old('seat_number') == $i ? 'selected' : '' }}>
                                            Seat {{ $i }}
                                        </option>
                                    @endif
                                @endfor
                            </select>
                            @error('seat_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Confirm Booking
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
