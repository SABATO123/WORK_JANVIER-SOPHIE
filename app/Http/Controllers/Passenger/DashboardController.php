<?php

namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
                          ->with(['route.bus'])
                          ->latest()
                          ->take(5)
                          ->get();

        $routes = Route::with('bus')
                      ->where('status', 'active')
                      ->whereDate('departure_time', '>=', now())
                      ->orderBy('departure_time')
                      ->paginate(10);

        return view('passenger.dashboard', compact('bookings', 'routes'));
    }

    public function getAllRoutes()
    {
        $routes = Route::with('bus')
                      ->where('status', 'active')
                      ->whereDate('departure_time', '>=', now())
                      ->orderBy('departure_time')
                      ->paginate(10);

        return view('passenger.routes', compact('routes'));
    }

    public function showBookingForm(Route $route)
    {
        // Get already booked seats for this route and travel date
        $bookedSeats = Booking::where('route_id', $route->id)
                             ->where('travel_date', Carbon::parse($route->departure_time)->toDateString())
                             ->where('status', 'confirmed')
                             ->pluck('seat_number')
                             ->toArray();

        return view('passenger.bookings.create', compact('route', 'bookedSeats'));
    }

    public function bookTicket(Request $request, Route $route)
    {
        $request->validate([
            'seat_number' => 'required|integer|min:1|max:' . $route->bus->total_seats,
            'travel_date' => 'required|date|after_or_equal:today',
            'passenger_name' => 'required|string',
            'passenger_phone' => 'required|string'
        ]);

        // Check if seat is available
        $seatTaken = Booking::where('route_id', $route->id)
                           ->where('travel_date', $request->travel_date)
                           ->where('seat_number', $request->seat_number)
                           ->where('status', 'confirmed')
                           ->exists();

        if ($seatTaken) {
            return back()->with('error', 'This seat is already booked. Please choose another seat.');
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'route_id' => $route->id,
            'travel_date' => $request->travel_date,
            'seat_number' => $request->seat_number,
            'total_amount' => $route->fare,
            'status' => 'confirmed',
            'passenger_details' => json_encode([
                'name' => $request->passenger_name,
                'phone' => $request->passenger_phone
            ])
        ]);

        return redirect()->route('passenger.bookings.show', $booking)
                         ->with('success', 'Ticket booked successfully!');
    }

    public function viewBookings()
    {
        $bookings = Booking::where('user_id', auth()->id())
                          ->with(['route.bus'])
                          ->latest()
                          ->paginate(10);

        return view('passenger.bookings.index', compact('bookings'));
    }

    public function showBooking(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('passenger.bookings.show', compact('booking'));
    }

    public function cancelBooking(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Booking is already cancelled.');
        }

        // Check if cancellation is allowed (e.g., not too close to departure)
        $departureTime = Carbon::parse($booking->route->departure_time);
        if ($departureTime->diffInHours(now()) < 24) {
            return back()->with('error', 'Cancellation is only allowed 24 hours before departure.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('passenger.bookings.index')
                        ->with('success', 'Booking cancelled successfully.');
    }
}
