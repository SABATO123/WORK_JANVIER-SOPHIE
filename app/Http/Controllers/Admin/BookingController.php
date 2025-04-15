<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Route;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['route.bus', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $routes = Route::with('bus')->get();
        $users = User::where('role', 'passenger')->get();

        return view('admin.bookings.create', compact('routes', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'route_id' => 'required|exists:routes,id',
            'travel_date' => 'required|date|after_or_equal:today',
            'seat_number' => 'required|integer|min:1',
            'passenger_name' => 'required|string',
            'passenger_phone' => 'required|string'
        ]);

        $route = Route::findOrFail($request->route_id);

        // Check if seat is available
        $seatTaken = Booking::where('route_id', $route->id)
            ->where('travel_date', $request->travel_date)
            ->where('seat_number', $request->seat_number)
            ->where('status', 'confirmed')
            ->exists();

        if ($seatTaken) {
            return back()
                ->withInput()
                ->with('error', 'This seat is already booked. Please choose another seat.');
        }

        $booking = Booking::create([
            'user_id' => $request->user_id,
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

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::with(['route.bus', 'user'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $booking = Booking::with(['route.bus', 'user'])->findOrFail($id);
        $routes = Route::with('bus')->get();
        $users = User::where('role', 'passenger')->get();

        return view('admin.bookings.edit', compact('booking', 'routes', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'route_id' => 'required|exists:routes,id',
            'travel_date' => 'required|date|after_or_equal:today',
            'seat_number' => 'required|integer|min:1',
            'passenger_name' => 'required|string',
            'passenger_phone' => 'required|string',
            'status' => 'required|in:confirmed,cancelled'
        ]);

        // If changing seat, check if new seat is available
        if ($booking->seat_number != $request->seat_number || 
            $booking->route_id != $request->route_id || 
            $booking->travel_date != $request->travel_date) {
            
            $seatTaken = Booking::where('route_id', $request->route_id)
                ->where('travel_date', $request->travel_date)
                ->where('seat_number', $request->seat_number)
                ->where('status', 'confirmed')
                ->where('id', '!=', $id)
                ->exists();

            if ($seatTaken) {
                return back()
                    ->withInput()
                    ->with('error', 'This seat is already booked. Please choose another seat.');
            }
        }

        $route = Route::findOrFail($request->route_id);

        $booking->update([
            'user_id' => $request->user_id,
            'route_id' => $request->route_id,
            'travel_date' => $request->travel_date,
            'seat_number' => $request->seat_number,
            'total_amount' => $route->fare,
            'status' => $request->status,
            'passenger_details' => json_encode([
                'name' => $request->passenger_name,
                'phone' => $request->passenger_phone
            ])
        ]);

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }
}
