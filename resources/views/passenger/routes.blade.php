@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Available Journeys</h4>
                </div>
                <div class="card-body">
                    @if($routes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Bus</th>
                                        <th>Departure</th>
                                        <th>Arrival</th>
                                        <th>Available Seats</th>
                                        <th>Fare</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($routes as $route)
                                        <tr>
                                            <td>{{ $route->from }}</td>
                                            <td>{{ $route->to }}</td>
                                            <td>{{ $route->bus->name }} ({{ $route->bus->bus_number }})</td>
                                            <td>{{ \Carbon\Carbon::parse($route->departure_time)->format('d M Y, h:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($route->arrival_time)->format('d M Y, h:i A') }}</td>
                                            <td>
                                                @php
                                                    $bookedSeats = \App\Models\Booking::where('route_id', $route->id)
                                                        ->where('status', 'confirmed')
                                                        ->whereDate('travel_date', \Carbon\Carbon::parse($route->departure_time)->toDateString())
                                                        ->count();
                                                    $availableSeats = $route->bus->total_seats - $bookedSeats;
                                                @endphp
                                                {{ $availableSeats }}
                                            </td>
                                            <td>{{ number_format($route->fare, 2) }}</td>
                                            <td>
                                                @if($availableSeats > 0)
                                                    <a href="{{ route('passenger.routes.book.form', $route->id) }}" 
                                                       class="btn btn-primary btn-sm">
                                                        Book Now
                                                    </a>
                                                @else
                                                    <span class="badge bg-danger">Fully Booked</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $routes->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            No journeys available at the moment.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
