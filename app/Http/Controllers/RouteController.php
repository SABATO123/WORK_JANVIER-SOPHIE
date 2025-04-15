<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::with('bus')
            ->whereDate('departure_time', '>=', now())
            ->where('status', 'active')
            ->orderBy('departure_time')
            ->paginate(10);
            
        return view('routes.index', compact('routes'));
    }
}
