<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/index', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth','user'])->group(function () {
Route::get('users/evenements', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->middleware(['check.banned'])->name('events.show');
Route::get('/filter', [EventController::class, 'filterByCategory'])->middleware(['check.banned'])->name('events.filter');
Route::get('/search', [EventController::class, 'searchByTitle'])->middleware(['check.banned'])->name('events.searchByTitle');
Route::post('/events/reserve', [UserController::class, 'reserve'])->middleware(['check.banned'])->name('events.reserve');
Route::get('/events/reservation/ticket/{event}', [UserController::class, 'generateTicket'])->middleware(['check.banned'])->name('events.generateTicket');
});
// Organizer routes
Route::middleware(['auth'])->group(function () {
    Route::get('/organizer/events/create', [OrganizerController::class, 'createEvent'])->name('organizer.createEvent');
    Route::post('/organizer/events/add', [OrganizerController::class, 'addEvent'])->name('organizer.addEvent');

    Route::get('/organizer/events/edit/{event}', [OrganizerController::class, 'editEvents'])->name('organizer.editEvents');
    Route::put('/organizer/events/update/{event}', [OrganizerController::class, 'updateEvent'])->name('organizer.updateEvent');
    Route::get('/organizer/events/delete/{event}', [OrganizerController::class, 'softdeleteEvents'])->name('organizer.softdeleteEvents');



    Route::get('/event/acceuil', [OrganizerController::class, 'eventStatistics'])->name('organizer.eventStatistics');
    Route::get('/event/eventacceptation', [OrganizerController::class, 'acceptation'])->name('organizer.acceptation');
    Route::post('/organizer/events/acceptation/{id}', [OrganizerController::class, 'reservation_valide'])->name('organizer.valide');
    Route::post('/organizer/events/acceptationall', [OrganizerController::class, 'accepted_all'])->name('organizer.valideall');


});

// Admin routes
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'restrectionUser'])->name('admin.restrectionUser');
    Route::post('/admin/users/{id}/ban', [AdminController::class, 'banUser'])->name('admin.users.ban');

    Route::post('/admin/users/{id}/unban', [AdminController::class, 'unbanUser'])->name('admin.users.unban');


    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');



    Route::get('/admin/categories/create', [AdminController::class, 'createCategory'])->name('admin.createCategory');
    Route::post('/admin/categories/add', [AdminController::class, 'store'])->name('admin.addCategory');

    Route::get('/admin/categories/edit/{categorie}', [AdminController::class, 'editCategory'])->name('admin.editCategory');
    Route::put('/admin/categories/update/{id}', [AdminController::class, 'updateCategory'])->name('admin.updateCategory');
    Route::get('/admin/categories/sofdelete/{categorie}', [AdminController::class, 'softdeleteCategory'])->name('admin.softdeleteCategory');



    Route::post('/admin/events/validate/{id}', [AdminController::class, 'validateEvents'])->name('admin.validateEvents');
    Route::get('/admin/events', [AdminController::class, 'events'])->name('admin.events');

    Route::get('/admin/statistics', [AdminController::class, 'platformStatistics'])->name('admin.platformStatistics');
});

require __DIR__.'/auth.php';
