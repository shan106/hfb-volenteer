<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->username ?? $user->name ?? $user->email }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col md:flex-row gap-6">
                    {{-- Avatar --}}
                    <div class="flex-shrink-0">
                        @if($user->avatar_path)
                            <img src="{{ asset('storage/' . $user->avatar_path) }}"
                                 alt="Avatar of {{ $user->username ?? $user->name ?? $user->email }}"
                                 class="h-32 w-32 rounded-full object-cover">
                        @else
                            <div class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center text-3xl font-semibold">
                                {{ strtoupper(substr($user->username ?? $user->name ?? $user->email, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold mb-2">
                            {{ $user->username ?? $user->name ?? $user->email }}
                        </h3>

                        <p class="text-sm text-gray-500 mb-2">
                            {{ $user->email }}
                        </p>

                        @if($user->birthday)
                            <p class="text-sm text-gray-600 mb-2">
                                🎂 {{ __('Birthday') }}:
                                {{ $user->birthday->format('d-m-Y') }}
                            </p>
                        @endif

                        @if($user->created_at)
                            <p class="text-sm text-gray-600 mb-4">
                                {{ __('Member since') }} {{ $user->created_at->format('d-m-Y') }}
                            </p>
                        @endif

                        @if($user->about)
                            <div class="mt-2">
                                <h4 class="font-semibold mb-1">{{ __('About') }}</h4>
                                <p class="text-gray-700 whitespace-pre-line">
                                    {{ $user->about }}
                                </p>
                            </div>
                        @endif

                        {{-- Hier later: tijdlijn met posts, activiteiten, etc. --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
