<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BusController extends Controller
{
  
    public function index()
    {
        $buses = Bus::latest()->paginate(10);
        return view('admin.buses.index', compact('buses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.buses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bus_number' => 'required|string|max:50|unique:buses',
            'type' => 'required|in:AC,Non-AC,Sleeper,Semi-Sleeper',
            'total_seats' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,maintenance',
            'features' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('buses', $filename, 'public');
            if ($path) {
                $data['image'] = $filename;
            }
        }

        Bus::create($data);

        return redirect()->route('admin.buses.index')
            ->with('success', 'Bus created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bus $bus)
    {
        return view('admin.buses.show', compact('bus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bus $bus)
    {
        return view('admin.buses.edit', compact('bus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bus $bus)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bus_number' => 'required|string|max:50|unique:buses,bus_number,' . $bus->id,
            'type' => 'required|in:AC,Non-AC,Sleeper,Semi-Sleeper',
            'total_seats' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,maintenance',
            'features' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($bus->image) {
                Storage::delete('public/buses/' . $bus->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/buses', $filename);
            $data['image'] = $filename;
        }

        $bus->update($data);

        return redirect()->route('admin.buses.index')
            ->with('success', 'Bus updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bus $bus)
    {
        if ($bus->image) {
            Storage::delete('public/buses/' . $bus->image);
        }

        $bus->delete();

        return redirect()->route('admin.buses.index')
            ->with('success', 'Bus deleted successfully.');
    }
}
