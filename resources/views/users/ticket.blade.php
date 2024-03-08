<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>
    <div class="bg-gray-100 py-10 min-h-screen">
        <div class="mx-auto max-w-7xl">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="container mx-auto px-4 py-8">
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-full lg:w-2/3 px-4 mb-8 lg:mb-0">
                            <img class="w-full rounded-lg shadow-lg" src="https://cdn.pixabay.com/photo/2016/11/23/15/48/audience-1853662_1280.jpg" alt="Event Image">
                        </div>
                        <div class="w-full lg:w-1/3 px-4">
                            <h1 class="text-4xl font-bold mb-4">{{ $event->title }}</h1>
                            <p class="text-lg mb-6">{{ $event->description }}</p>
                            <div class="mb-6">
                                <p class="text-xl font-bold mb-2">When:</p>
                                <p class="text-lg">{{ $event->date->format('l, F jS, Y') }} at {{ $event->date->format('g:i A') }}</p>
                            </div>
                            <div class="mb-6">
                                <p class="text-xl font-bold mb-2">Where:</p>
                                <p class="text-lg">{{ $event->location }}</p>
                            </div>
                            <div class="mb-6">
                                <p class="text-xl font-bold mb-2">Reserved By:</p>
                                <p class="text-lg">{{ $user->name }}</p>
                                <p class="text-lg">{{ $user->email }}</p>
                                <p class="text-lg">{{ $user->phone }}</p>
                            </div>
                            <div class="mb-6">
                                <p class="text-xl font-bold mb-2">Reservation Date:</p>
                                <p class="text-lg">{{ $reservation->created_at->format('l, F jS, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
