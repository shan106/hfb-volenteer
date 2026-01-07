<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Volunteers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Zoekformulier --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="get" action="{{ route('users.index') }}" class="flex gap-2">
                    <x-text-input
                        id="q"
                        name="q"
                        type="text"
                        class="block w-full"
                        placeholder="{{ __('Search by name, username or email') }}"
                        value="{{ request('q') }}"
                    />
                    <x-primary-button>
                        {{ __('Search') }}
                    </x-primary-button>
                </form>
            </div>

            {{-- Lijst van gebruikers --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($users->count())
                        <ul class="divide-y divide-gray-200">
                            @foreach($users as $user)
                                <li class="py-4 flex items-center gap-4">
                                    {{-- Avatar / initiaal (ALTIJD zelfde grootte) --}}
                                    @php
                                        $displayName = $user->username ?? $user->name ?? $user->email;
                                    @endphp

                                    @if($user->avatar_path)
                                        <img
                                            src="{{ asset('storage/' . $user->avatar_path) }}"
                                            alt="Avatar of {{ $displayName }}"
                                            class="h-14 w-14 aspect-square shrink-0 rounded-full object-cover object-center ring-1 ring-gray-200"
                                        >
                                    @else
                                        <div class="h-14 w-14 aspect-square shrink-0 rounded-full bg-gray-200 flex items-center justify-center text-lg font-semibold text-gray-700 ring-1 ring-gray-200">
                                            {{ strtoupper(mb_substr($displayName, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('users.show', $user) }}"
                                           class="font-semibold text-gray-900 hover:underline">
                                            {{ $displayName }}
                                        </a>

                                        <div class="text-sm text-gray-500 truncate">
                                            {{ $user->email }}
                                        </div>

                                        @if($user->about)
                                            <p class="text-sm text-gray-700 mt-1 line-clamp-2">
                                                {{ Str::limit($user->about, 120) }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="shrink-0">
                                        <a href="{{ route('users.show', $user) }}"
                                           class="text-sm text-indigo-600 hover:text-indigo-800">
                                            {{ __('View profile') }}
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    @else
                        <p class="text-gray-600">
                            {{ __('No users found.') }}
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
