<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = Route::with('bus')->latest()->paginate(10);
        return view('admin.routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buses = Bus::where('status', 'active')->get();
        return view('admin.routes.create', compact('buses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bus_id' => 'required|exists:buses,id',
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i|after:departure_time',
            'fare' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['departure_time'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d ') . $request->departure_time));
        $data['arrival_time'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d ') . $request->arrival_time));
        Route::create($data);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Route $route)
    {
        return view('admin.routes.show', compact('route'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route $route)
    {
        $buses = Bus::where('status', 'active')->get();
        return view('admin.routes.edit', compact('route', 'buses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Route $route)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bus_id' => 'required|exists:buses,id',
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i|after:departure_time',
            'fare' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['departure_time'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d ') . $request->departure_time));
        $data['arrival_time'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d ') . $request->arrival_time));
        $route->update($data);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        $route->delete();

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route deleted successfully.');
    }
}
