<?php

namespace App\Http\Controllers;

use App\Models\PickupGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class PickupGameController extends Controller
{
    /**
     * Store a newly created pickup game in the database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'location_details' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $game = PickupGame::create([
                'game_date' => $request->game_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $request->location,
                'location_details' => $request->location_details,
                'is_active' => true,
                'notes' => $request->notes,
            ]);

            session()->flash('success', 'Pickup game created successfully!');
            return redirect()->route('calendar');
        } catch (\Exception $e) {
            Log::error("Error creating pickup game: " . $e->getMessage());
            session()->flash('error', "An error occurred while creating the pickup game. (Error: " . $e->getMessage() . ")");
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display a listing of active pickup games (for the calendar page).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch active pickup games ordered by game_date and start_time
        $games = PickupGame::where('is_active', true)
            ->orderBy('game_date')
            ->orderBy('start_time')
            ->get();

        // Pass the games to the calendar view (assumed to be 'calendar')
        return View::make('calendar', compact('games'));
    }
}
