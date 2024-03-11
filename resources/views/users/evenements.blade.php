<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Events') }}
        </h2>
        @if(!@auth()->user()->banned)
        <form method="GET" action="{{ route('events.searchByTitle') }}" class="mt-4">
            <div class="flex items-center">
                <input type="text" name="search" id="search" class="block w-full sm:w-auto px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none" placeholder="Search by title">
                <button type="submit" class="inline-flex items-center px-4 py-2 ml-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">Search</button>
            </div>
        </form>
        @endif
    </x-slot>
    <div class="bg-gray-100 py-10 min-h-screen">
        <div class="mx-auto max-w-7xl">
            <div class="px-4 sm:px-6 lg:px-8">
                @if(!request()->has('category') && !auth()->user()->banned )
                    <form method="GET" action="{{ route('events.filter') }}">
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Filter by Category:</label>
                                <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="submit"  class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Filter</button>
                            </div>
                        </div>
                    </form>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @if($events->isEmpty())
                        <p class="text-gray-700">No events found for the selected category.</p>
                    @else
                        @foreach($events as $event)
                            <div class="relative flex flex-col mt-6 text-gray-700 bg-white shadow-md bg-clip-border rounded-xl">
                                <div class="p-6">
                                    <h5 class="block mb-2 font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                                        {{ $event->title }}
                                    </h5>
                                    <p class="block font-sans text-base antialiased font-light leading-relaxed text-inherit">
                                        {{ $event->description }}
                                    </p>
                                    <p class="block font-bold text-base antialiased  leading-relaxed text-inherit">
                                        {{ $event->category->name }}
                                    </p>
                                </div>
                                <div class="p-6 pt-0">
                                    @if(auth()->user()->banned)
                                        <p class="text-red-600">You are banned and cannot view this event.</p>
                                    @else
                                        <a href="{{ route('events.show', $event->id) }}"
                                           class="align-middle select-none font-sans font-bold text-center uppercase transition-all text-xs py-3 px-6 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none">
                                            Show More
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="mt-8">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
