{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Standaard kaart --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            {{-- FAQ blok onderaan dashboard (voor gewone gebruikers) --}}
            @auth
                @unless(auth()->user()->is_admin)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">
                            {{ __('Frequently Asked Questions') }}
                        </h3>

                        @forelse($categories as $category)
                            @if($category->faqs->count())
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-700 mb-2">
                                        {{ $category->name }}
                                    </h4>

                                    <div class="bg-white shadow-sm sm:rounded-lg divide-y">
                                        @foreach($category->faqs as $faq)
                                            <details class="group">
                                                <summary class="flex justify-between items-center px-4 py-2 cursor-pointer">
                                                    <span class="text-sm font-medium text-gray-800">
                                                        {{ $faq->question }}
                                                    </span>
                                                    <span class="text-gray-400 group-open:rotate-180 transition-transform">
                                                        ▼
                                                    </span>
                                                </summary>
                                                <div class="px-4 pb-3 text-sm text-gray-700">
                                                    {!! nl2br(e($faq->answer)) !!}
                                                </div>
                                            </details>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-gray-500 text-sm">
                                {{ __('There are no FAQ items yet.') }}
                            </p>
                        @endforelse
                    </div>
                @endunless
            @endauth

        </div>
    </div>
</x-app-layout>
