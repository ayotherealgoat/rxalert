<?php

namespace App\Http\Controllers;

use App\Moedls\User;
use App\Models\Medication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    // Show list of reminders for the logged-in user
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        $reminders = $user->medications()->latest()->get();

        // return view('reminders.index', compact('reminders'));
        return view('dashboard', compact('reminders'));
    }

    // Show form to create a new reminder
    public function create()
    {
        return view('reminders.create');
    }

    // Store new reminder
    public function store(Request $request)
    {
        // Validate using correct field names based on your migration
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'dosage'          => 'required|string|max:255',
            'times_per_day'   => 'required|integer|min:1',
            'first_dose_time' => 'required|date_format:H:i',
            'notes'           => 'nullable|string',
        ]);

        // Create reminder linked to authenticated user
        $medication = new Medication($validated);
        $medication->user_id = Auth::id();
        $medication->save();

        // return redirect()
            // ->route('dashboard')->with('success', 'Medication reminder created successfully.');
            return redirect('/dashboard')->with('success', 'Medication reminder created successfully.');

    }

    // Show form to edit an existing reminder
        public function edit($id)
    {
        $reminder = Medication::where('user_id', Auth::id())->findOrFail($id);
        return view('reminders.edit', compact('reminder'));
    }

    // Update an existing reminder
    public function update(Request $request, $reminder)
    {
        $reminder = Medication::where('user_id', Auth::id())->findOrFail($reminder);

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'dosage'          => 'required|string|max:255',
            'times_per_day'   => 'required|integer|min:1',
            'first_dose_time' => 'required|date_format:H:i',
            'notes'           => 'nullable|string',
        ]);

        $reminder->update($validated);

        // return redirect()
        //     ->route('/dashboard') // Use the correct route name
        //     ->with('success', 'Medication reminder updated successfully.');
        return redirect('/dashboard')->with('success', 'Medication reminder updated successfully.');
    }


}
