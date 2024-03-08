<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Statistics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="text-center">
                            <div class="flex items-center justify-center w-10 h-10 mx-auto mb-3 rounded-full bg-teal-accent-400 sm:w-12 sm:h-12">
                                <svg class="w-8 h-8 text-teal-900 sm:w-10 sm:h-10" stroke="currentColor" viewBox="0 0 52 52">
                                    <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                                </svg>
                            </div>
                            <h6 class="text-4xl font-bold text-teal-900 dark:text-teal-400">{{ $userCount }}</h6>
                            <p class="mb-2 font-bold text-md text-gray-700 dark:text-gray-400">Users</p>
                            <p class="text-gray-700 dark:text-gray-400">Total number of users.</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center w-10 h-10 mx-auto mb-3 rounded-full bg-teal-accent-400 sm:w-12 sm:h-12">
                                <svg class="w-8 h-8 text-teal-900 sm:w-10 sm:h-10" stroke="currentColor" viewBox="0 0 52 52">
                                    <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                                </svg>
                            </div>
                            <h6 class="text-4xl font-bold text-teal-900 dark:text-teal-400">{{ $eventCount }}</h6>
                            <p class="mb-2 font-bold text-md text-gray-700 dark:text-gray-400">Events</p>
                            <p class="text-gray-700 dark:text-gray-400">Total number of events.</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center w-10 h-10 mx-auto mb-3 rounded-full bg-teal-accent-400 sm:w-12 sm:h-12">
                                <svg class="w-8 h-8 text-teal-900 sm:w-10 sm:h-10" stroke="currentColor" viewBox="0 0 52 52">
                                    <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                                </svg>
                            </div>
                            <h6 class="text-4xl font-bold text-teal-900 dark:text-teal-400">{{ $reservationCount }}</h6>
                            <p class="mb-2 font-bold text-md text-gray-700 dark:text-gray-400">Reservations</p>
                            <p class="text-gray-700 dark:text-gray-400">Total number of reservations.</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center w-10 h-10 mx-auto mb-3 rounded-full bg-teal-accent-400 sm:w-12 sm:h-12">
                                <svg class="w-8 h-8 text-teal-900 sm:w-10 sm:h-10" stroke="currentColor" viewBox="0 0 52 52">
                                    <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                                </svg>
                            </div>
                            <h6 class="text-4xl font-bold text-teal-900 dark:text-teal-400">{{ $organizerCount }}</h6>
                            <p class="mb-2 font-bold text-md text-gray-700 dark:text-gray-400">Organizers</p>
                            <p class="text-gray-700 dark:text-gray-400">Total number of organizers.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
