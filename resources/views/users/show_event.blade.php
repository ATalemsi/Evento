<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>
    <div class="bg-gray-100 py-10 min-h-screen">
        <div class="mx-auto max-w-7xl">
            <div class="px-4 sm:px-6 lg:px-8">
                <div>
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900">Event Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Personal details and Reservation.</p>
                    </div>
                    <div class="mt-6 border-t border-gray-200">
                        <dl class="divide-y divide-gray-200">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Title</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2">{{ $event->title }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Description</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2">{{ $event->description }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Date</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2">{{ $event->date->format('d/m/Y') }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Location</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2">{{ $event->location }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Place Number</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2">{{ $event->place_number }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Category</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2">{{ $event->category->name }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Organized By</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2">{{ $event->organizer->name }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Reservation</dt>
                                <dd class="mt-2 text-sm text-gray-900 sm:col-span-2">
                                    @if($hasReserved)
                                        <p class="text-green-600 mb-6">You have already reserved a place for this event.</p>
                                        <a href="{{ route('events.generateTicket', $event->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 transition">Get Ticket</a>
                                    @elseif($hasPending)
                                        <p class="text-orange-700">The Reservation is not valid yes with moment</p>
                                    @else
                                        <form method="POST" action="{{ route('events.reserve') }}">
                                            @csrf
                                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Reserve Now</button>
                                        </form>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
