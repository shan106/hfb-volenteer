<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Volunteers') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Zoekformulier --}}
            <div class="bg-white shadow-sm rounded-xl p-5">
                <form method="get" action="{{ route('users.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <label for="q" class="sr-only">{{ __('Search volunteers') }}</label>
                        <input
                            id="q"
                            name="q"
                            type="search"
                            value="{{ $search }}"
                            placeholder="{{ __('Search by name, username or description') }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm
                                   focus:border-[#0071bc] focus:ring-[#0071bc]"
                        >
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                                class="px-5 py-2 rounded-lg bg-[#0071bc] text-white text-sm font-semibold
                                       hover:bg-[#005a96] transition-colors">
                            {{ __('Search') }}
                        </button>

                        @if($search !== '')
                            <a href="{{ route('users.index') }}"
                               class="px-5 py-2 rounded-lg border border-gray-300 text-sm font-semibold
                                      text-gray-700 hover:bg-gray-50 transition-colors">
                                {{ __('Clear') }}
                            </a>
                        @endif
                    </div>
                </form>

                @if($search !== '')
                    <p class="text-sm text-gray-500 mt-3">
                        {{ trans_choice('{0}No volunteers found for ":q"|{1}1 volunteer found for ":q"|[2,*]:count volunteers found for ":q"', $users->total(), ['q' => $search, 'count' => $users->total()]) }}
                    </p>
                @endif
            </div>

            {{-- Resultaten --}}
            @if($users->count())
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($users as $user)
                        <x-volunteer-card :user="$user" />
                    @endforeach
                </div>

                <div>
                    {{ $users->links() }}
                </div>
            @else
                <div class="bg-white shadow-sm rounded-xl p-12 text-center">
                    <p class="font-semibold text-gray-900">{{ __('No volunteers found') }}</p>
                    <p class="text-sm text-gray-600 mt-1">
                        @if($search !== '')
                            {{ __('Try a different search term, or clear the search to see everyone.') }}
                        @else
                            {{ __('Volunteers will appear here once they create a profile.') }}
                        @endif
                    </p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>