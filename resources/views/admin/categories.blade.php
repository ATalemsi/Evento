<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>
    <div class="bg-gray-100 py-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div>

                <ul role="list" class="mt-3 grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($categories as $category)
                        <li class="col-span-1 flex shadow-sm rounded-md">
                            <div class="flex-shrink-0 flex items-center justify-center w-16 bg-pink-600 text-white text-sm font-medium rounded-l-md">
                                {{ strtoupper(substr($category->name, 0, 2)) }}
                            </div>
                            <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                                <div class="flex-1 px-4 py-2 text-sm truncate">
                                    <a href="#" class="text-gray-900 font-medium hover:text-gray-600">{{ $category->name }}</a>
                                </div>
                                <div class="flex-shrink-0 pr-2">
                                    <a href="{{  route('admin.editCategory', $category->id) }}" class="w-8 h-8 bg-white inline-flex items-center justify-center text-green-400 rounded-full bg-transparent hover:text-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span class="sr-only">Edit category</span>
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{  route('admin.softdeleteCategory', $category->id) }}" class="w-8 h-8 bg-white inline-flex items-center justify-center text-red-400 rounded-full bg-transparent hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span class="sr-only">Delete category</span>
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
</x-app-layout>
