<?php

namespace App\Http\Controllers;

use App\Models\Acceptation;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;

class UserController extends Controller
{

        public function reserve(Request $request)
    {
        $event = Event::find($request->event_id);

        // Check if the event exists
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        // Check if the event has available places
        if ($event->place_number <= 0) {
            return redirect()->back()->with('error', 'No available places for this event.');
        }

        // Check if the event has automatic acceptance
        if ($event->acceptation == 'automatique') {
            // Create reservation
            Reservation::create([
                'event_id' => $event->id,
                'user_id' => auth()->id(),
            ]);

            // Decrease available places by one
            $event->decrement('place_number');

            return redirect()->back()->with('success', 'Reservation successful.');
        } elseif ($event->acceptation == 'manuel') {
            // Create acceptance with pending status
            Acceptation::create([
                'event_id' => $event->id,
                'user_id' => auth()->id(),
                'status' => 'pending',
            ]);

            return redirect()->back()->with('success', 'Reservation pending approval.');
        } else {
            return redirect()->back()->with('error', 'Invalid acceptance attribute.');
        }
    }


    public function generateTicket($eventId)
    {
        $reservation = Reservation::where('event_id', $eventId)->firstOrFail();
        $event = $reservation->event;
        $user = $reservation->user;
        return view('users.ticket', compact('event', 'reservation', 'user'));

    }
}
