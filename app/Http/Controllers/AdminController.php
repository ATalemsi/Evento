<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function categories()
    {
        $categories = Categorie::all();


        return view('admin.categories',compact('categories'));
    }
    public function restrectionUser()
    {
        $users = User::where('banned', false)->where('role', 'user')->get();
        $bannedUsers = User::where('banned', true)->where('role', 'user')->get();

        return view('admin.users',compact('users', 'bannedUsers'));
    }
    public function banUser($id)
    {
        $user = User::findOrFail($id);
        $user->ban();
        return redirect()->back()->with('success', 'User has been banned.');
    }

    public function unbanUser($id)
    {
        $user = User::findOrFail($id);
        $user->unban();
        return redirect()->back()->with('success', 'User has been unbanned.');
    }
    public function createCategory()
    {
        return view('admin.add');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
         Categorie::create([
            'name' => $request->input('name'),

        ]);
        return redirect()->route('admin.categories')->with('success', 'Category added successfully.');

    }
    public function editCategory($id)
    {
        $category = Categorie::findOrFail($id);
        return view('admin.edit', compact('category'));

    }
    public function updateCategory(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',

        ]);
        Categorie::where('id', $id)->update([
            'name' => $request->name,

        ]);
        return redirect()->route('admin.categories')->with('success', 'Category updated successfully');

    }
    public function softdeleteCategory($id)
    {
        $category = Categorie::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');

    }
    public function validateEvents($id)
    {
        $event = Event::findOrFail($id);
        $event->validate();
        return redirect()->back()->with('success', 'Event Was Valid.');
    }
    public function events()
    {
        $events = Event::where('validate', false)->get();
        return view('admin.evenements',compact('events'));
    }
    public function platformStatistics()
    {
        // Total number of users
        $userCount =  User::where('role', 'user')->count();

        // Total number of events
        $eventCount = Event::count();

        // Total number of categories
        $categoryCount = Categorie::count();

        // Total number of reservations
        $reservationCount = Reservation::count();

        // Total number of accepted reservations
        $acceptedReservationCount = Reservation::count();

        // Average number of reservations per event
        $averageReservationsPerEvent = $reservationCount > 0 ? $reservationCount / $eventCount : 0;

        // Total number of organizers
        $organizerCount = User::where('role', 'organisateur')->count();

        return view('admin.statistique', [
            'userCount' => $userCount,
            'eventCount' => $eventCount,
            'categoryCount' => $categoryCount,
            'reservationCount' => $reservationCount,
            'acceptedReservationCount' => $acceptedReservationCount,
            'averageReservationsPerEvent' => $averageReservationsPerEvent,
            'organizerCount' => $organizerCount,

        ]);


    }

}
