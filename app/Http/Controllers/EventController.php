<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        auth()->user();
        // Ensure that the authenticated user is an organizer
        $events = Event::where('validate', true)->paginate(10);
        $categories = Categorie::all();
        return view('users.evenements',compact('events','categories'));
    }

    public function show($id)
    {
        $event = Event::with('category', 'organizer')->findOrFail($id);
        $user = auth()->user();
        $hasReserved = $event->reservations()->where('user_id', $user->id)->exists();
        $hasPending = $event->acceptation()->where('user_id', $user->id)->exists();
        return view('users.show_event', compact('event', 'hasReserved','hasPending'));
    }

    public function filterByCategory(Request $request)
    {
        $categoryId = $request->input('category');
        $events = Event::query()->where('validate', true);

        if ($categoryId) {
            $events->whereHas('category', function ($query) use ($categoryId) {
                $query->where('id', $categoryId);
            });
        }
        $events = $events->paginate(10);
        return view('users.evenements', compact('events'));
    }
    public function searchByTitle(Request $request)
    {
        $searchQuery = $request->input('search');

        // Perform the search query to find events with titles matching the search query
        $events = Event::where('title', 'like', '%' . $searchQuery . '%')
            ->where('validate', true)
            ->paginate(10);

        $categories = Categorie::all();

        // Return the view with the search results
        return view('users.evenements', compact('events', 'categories'));
    }

}
