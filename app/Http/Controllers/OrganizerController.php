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

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|exists:categories,id',
            'acceptation'=>'required',
            'place_number' => 'required|integer|min:1',
        ]);


        $event = Event::findOrFail($id);


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
        $events = Event::where('organizer_id',auth()->user()->id)->get();
        $user =auth()->user();
        $organizerEvents = Event::where('organizer_id', $user->id)->get();
        $eventStatistics = [];
        foreach ($organizerEvents as $event) {

            $reservationCount = $event->reservations()->where('event_id', $event->id)->count();
            $totalPlaces = $event->place_number;
            $reservedPlaces = $reservationCount;
            $unreservedPlaces = $totalPlaces ;


            $eventStatistics[] = [
                'event_name' => $event->title,
                'reservation_count' => $reservationCount,
                'reserved_places' => $reservedPlaces,
                'unreserved_places' => $unreservedPlaces,
            ];
        }

        return view('events.acceuil', compact('eventStatistics','events'));
    }
    public function acceptation()
    {
        $organizerId = auth()->id();


        $pendingReservations = Acceptation::whereHas('event', function ($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })->where('status', 'pending')->get();


        $eventsWithReservations = [];


        foreach ($pendingReservations as $reservation) {

            $event = $reservation->event;


            $user = $reservation->user;


            $status = $reservation->status;

            $acceptationId = $reservation->id;


            $eventsWithReservations[] = [
                'event' => $event,
                'user' => $user,
                'status' => $status,
                'acceptationId'=> $acceptationId

            ];
        }


        return view('events.eventacceptation', compact('eventsWithReservations'));

    }
    public function reservation_valide(Request $request)
    {
        $request->validate([
            'acceptation_id' => 'required|exists:acceptations,id',
            'event_id'=> 'required|exists:events,id'
        ]);


        $acceptation = Acceptation::findOrFail($request->acceptation_id);
        $event = Event::find($request->event_id);


        $acceptation->update(['status' => 'accepted']);


        Reservation::create([
            'event_id' => $acceptation->event_id,
            'user_id' => $acceptation->user_id,
        ]);
        $event->decrement('place_number');


        return redirect()->back()->with('success', 'Reservation accepted successfully.');

    }
    public function accepted_all(){
        $acceptation = Acceptation::all();
        $acceptation->update(['status' => 'accepted']);
        return redirect()->back()->with('success', 'Reservation accepted successfully.');
    }

}
