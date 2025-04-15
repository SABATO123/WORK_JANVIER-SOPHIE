<?php

namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function search(Request $request)
    {
        $routes = Route::with('bus')
            ->where('from', 'like', '%'.$request->from.'%')
            ->where('to', 'like', '%'.$request->to.'%')
            ->where('status', 'active')
            ->whereDate('departure_time', $request->date)
            ->get();

        return view('passenger.search', compact('routes'));
    }

    public function create(Request $request, Route $route)
    {
        return view('passenger.book', compact('route'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'seats' => 'required|array|min:1',
            'seats.*' => 'integer|min:1|max:50',
            'passenger_name' => 'required|string|max:255',
            'passenger_phone' => 'required|string|max:20'
        ]);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'route_id' => $validated['route_id'],
            'passenger_name' => $validated['passenger_name'],
            'passenger_phone' => $validated['passenger_phone'],
            'seats' => json_encode($validated['seats']),
            'status' => 'confirmed',
            'total_fare' => Route::find($validated['route_id'])->fare * count($validated['seats'])
        ]);

        return redirect()->route('passenger.bookings.show', $booking)
            ->with('success', 'Booking confirmed!');
    }

    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->latest()->get();
        return view('passenger.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        return view('passenger.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('passenger.bookings.index')
            ->with('success', 'Booking cancelled successfully');
    }
}
