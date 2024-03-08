<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Event') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Validation Error!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="max-w-xl">
                    <section>
                        <form method="post" action="{{ route('organizer.addEvent') }}" class="mt-6 space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="title" :value="__('Event Name')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" autocomplete="off" />
                            </div>
                            <div>
                                <x-input-label for="date" :value="__('Event Date')" />
                                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" autocomplete="off" />
                            </div>
                            <div>
                                <x-input-label for="location" :value="__('Event Location')" />
                                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" autocomplete="off" />
                            </div>
                            <div>
                                <x-input-label for="description" :value="__('Event Description')" />
                                <textarea id="description" name="description" class="mt-1 block w-full" rows="4" autocomplete="off"></textarea>
                            </div>
                            <div>
                                <x-input-label for="category" :value="__('Event Category')" />
                                <select id="category" name="category" class="mt-1 block w-full" autocomplete="off">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="acceptation" :value="__('Type acceptation')" />
                                <select id="acceptation" name="acceptation" class="mt-1 block w-full" autocomplete="off">
                                    <option value="automatique">Automatique</option>
                                    <option value="manuel">Manuel</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="place_number" :value="__('Available Places')" />
                                <x-text-input id="place_number" name="place_number" type="number" class="mt-1 block w-full" autocomplete="off" />
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Create Event') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

