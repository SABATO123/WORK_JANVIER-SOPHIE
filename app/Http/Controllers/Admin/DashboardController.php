<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuses = Bus::count();
        $activeRoutes = Route::where('status', 'active')->count();
        $todayBookings = Booking::whereDate('created_at', today())->count();
        $totalPassengers = User::where('role', 'passenger')->count();

        return view('admin.dashboard', compact(
            'totalBuses',
            'activeRoutes',
            'todayBookings',
            'totalPassengers'
        ));
    }
}
