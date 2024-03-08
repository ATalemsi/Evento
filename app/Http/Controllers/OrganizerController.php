<?php

namespace App\Http\Controllers;

use App\Models\Acceptation;
use App\Models\Categorie;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{

    public function createEvent()
    {
        $categories = Categorie::all();
        return view('events.add', compact('categories'));

    }
    public function addEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|exists:categories,id',
            'acceptation'=>'required',
            'place_number' => 'required|integer|min:1',
        ]);

        Event::create([
            'title' => $request->title,
            'date' => $request->date,
            'location' => $request->location,
            'description' => $request->description,
            'category_id' => $request->category,
            'place_number' => $request->place_number,
            'acceptation' => $request->acceptation,
            'organizer_id' => auth()->user()->id,
        ]);

        return  redirect()->route('organizer.eventStatistics')->with('success', 'Event added successfully.');
    }
    public function editEvents($id)
    {
        $event = Event::with('category')->findOrFail($id);
        $categories = Categorie::all();
        return view('events.edit', compact('event', 'categories'));

    }
    public function updateEvent(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|exists:categories,id',
            'acceptation'=>'required',
            'place_number' => 'required|integer|min:1',
        ]);

        // Find the event by ID
        $event = Event::findOrFail($id);

        // Update the event data
        $event->update([
            'title' => $validatedData['title'],
            'date' => $validatedData['date'],
            'location' => $validatedData['location'],
            'description' => $validatedData['description'],
            'place_number' => $validatedData['place_number'],
            'acceptation' => $validatedData['acceptation'],
            'category_id' => $validatedData['category'],
        ]);

        return  redirect()->route('organizer.eventStatistics')->with('success', 'Event updated successfully.');
    }

    public function softdeleteEvents($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully.');

    }
    public function eventStatistics()
    {
        $events = Event::all();
        // Retrieve the authenticated user
        $user =auth()->user();


        // Ensure that the authenticated user is an organizer
        if ($user->role !== 'organisateur') {
            // Handle unauthorized access
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Retrieve all events associated with the organizer
        $organizerEvents = Event::where('organizer_id', $user->id)->get();

        // Initialize an array to store event statistics
        $eventStatistics = [];

        // Loop through each event
        foreach ($organizerEvents as $event) {
            // Calculate statistics for the event
            $reservationCount = $event->reservations()->where('event_id', $event->id)->count();
            // Calculate the number of reserved and unreserved places
            $totalPlaces = $event->place_number;
            $reservedPlaces = $reservationCount;
            $unreservedPlaces = $totalPlaces ;

            // Add event statistics to the array
            $eventStatistics[] = [
                'event_name' => $event->title,
                'reservation_count' => $reservationCount,
                'reserved_places' => $reservedPlaces,
                'unreserved_places' => $unreservedPlaces,
            ];
        }
        // Return the event statistics compacted for the view
        return view('events.acceuil', compact('eventStatistics','events'));
    }
    public function acceptation()
    {
        // Get all reservations that are pending validation
        $pendingReservations = Acceptation::where('status', 'pending')->get();

        // Prepare an array to store event details along with reserved user and status
        $eventsWithReservations = [];

        // Iterate through each pending reservation
        foreach ($pendingReservations as $reservation) {
            // Get the event associated with the reservation
            $event = $reservation->event;

            // Get the user who made the reservation
            $user = $reservation->user;

            // Get the reservation status
            $status = $reservation->status;

            $acceptationId = $reservation->id;

            // Add event, reserved user, and status details to the array
            $eventsWithReservations[] = [
                'event' => $event,
                'user' => $user,
                'status' => $status,
                'acceptationId'=> $acceptationId

            ];
        }

        // Pass the array to the view
        return view('events.eventacceptation', compact('eventsWithReservations'));

    }
    public function reservation_valide(Request $request)
    {
        $request->validate([
            'acceptation_id' => 'required|exists:acceptations,id',
            'event_id'=> 'required|exists:events,id'
        ]);

        // Find the acceptation by ID
        $acceptation = Acceptation::findOrFail($request->acceptation_id);
        $event = Event::find($request->event_id);

        // Update the status of acceptation to "accepted"
        $acceptation->update(['status' => 'accepted']);

        // Create a new reservation based on the accepted acceptation
        Reservation::create([
            'event_id' => $acceptation->event_id,
            'user_id' => $acceptation->user_id,
        ]);
        $event->decrement('place_number');

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Reservation accepted successfully.');

    }

}
