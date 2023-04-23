<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('games.store') }}">
            @csrf
            <textarea
                name="title"
                placeholder="{{ __('Game name') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('title') }}</textarea>
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
            <x-primary-button class="mt-4">Add a {{ __('Game') }}</x-primary-button>
        </form>

        <div
            x-data="{ open: false }"
            class="relative"
        >
            <x-primary-button
                x-on:click="open = true"
                class="flex items-center mt-4 focus:bg-gray-400 text-gray-700 focus:text-gray-900 font-semibold rounded focus:outline-none focus:shadow-inner py-2 px-4"
                type="button"
            >
                Export
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"  style="margin-top:3px">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </x-primary-button>
            <ul
                x-show="open"
                x-on:click.away="open = false"
                class="bg-white text-gray-700 rounded shadow-lg absolute py-2 mt-1"
                style="min-width:15rem"
            >
                <li>
                    <a href="{{ route('games.export') }}" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">
                        CSV
                    </a>
                </li>
                <li>
                    <a href="#" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">
                        XML
                    </a>
                </li>
                <li>
                    <a href="#" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">
                        JSON
                    </a>
                </li>
            </ul>
        </div>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($games as $game)
                <div class="p-6 flex space-x-2">
                    <div class="flex-1">
                        <p class="text-lg text-gray-900">{{ $game->title }}</p>
                        <div class="flex justify-between items-center">
                            <div class="text-gray-800 text-xs text-right">
                                Added by {{ $game->user->name }} on {{ $game->created_at->format('j M Y, g:i a') }}.
                            </div>
                            @if ($game->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <form method="POST" action="{{ route('games.destroy', $game) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('games.destroy', $game)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
