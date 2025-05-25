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

    /**
     * Display a single pickup game and its signups.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $game = PickupGame::with(['signups.user'])->findOrFail($id);
        $signups = $game->signups;
        return view('game', compact('game', 'signups'));
    }

    /**
     * Sign up the authenticated user for a pickup game.
     */
    public function signup(Request $request, $id)
    {
        $request->validate([
            'comment' => 'nullable|string|max:255',
        ]);
        $game = PickupGame::findOrFail($id);
        $signup = $game->signups()->firstOrCreate(
            ['user_id' => $request->user()->id],
            ['comment' => $request->comment]
        );
        if ($signup->wasRecentlyCreated === false) {
            $signup->comment = $request->comment;
            $signup->save();
        }
        return redirect()->route('game', $id)->with('success', 'Signed up successfully!');
    }

    /**
     * Update the signup note for the authenticated user.
     */
    public function updateSignup(Request $request, $id)
    {
        $request->validate([
            'comment' => 'nullable|string|max:255',
        ]);
        $game = PickupGame::findOrFail($id);
        $signup = $game->signups()->where('user_id', $request->user()->id)->firstOrFail();
        $signup->comment = $request->comment;
        $signup->save();
        return redirect()->route('game', $id)->with('success', 'Signup note updated!');
    }

    /**
     * Cancel the signup for the authenticated user.
     */
    public function cancelSignup(Request $request, $id)
    {
        $game = PickupGame::findOrFail($id);
        $signup = $game->signups()->where('user_id', $request->user()->id)->first();
        if ($signup) {
            $signup->delete();
        }
        return redirect()->route('game', $id)->with('success', 'Signup cancelled.');
    }
}
