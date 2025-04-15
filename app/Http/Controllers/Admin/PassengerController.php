<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PassengerController extends Controller
{
    public function index()
    {
        $passengers = User::where('role', 'passenger')
            ->latest()
            ->paginate(10);
        
        return view('admin.passengers.index', compact('passengers'));
    }

    public function show(User $passenger)
    {
        return view('admin.passengers.show', compact('passenger'));
    }

    public function edit(User $passenger)
    {
        return view('admin.passengers.edit', compact('passenger'));
    }

    public function update(Request $request, User $passenger)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $passenger->id,
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        $passenger->update($validated);

        return redirect()->route('admin.passengers.index')
            ->with('success', 'Passenger updated successfully');
    }

    public function destroy(User $passenger)
    {
        $passenger->delete();

        return redirect()->route('admin.passengers.index')
            ->with('success', 'Passenger deleted successfully');
    }
}
