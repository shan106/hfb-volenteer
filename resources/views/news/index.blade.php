<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Latest News') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="grid gap-6 justify-items-start
                        sm:grid-cols-2 lg:grid-cols-3">
                @forelse($newsItems as $item)
                    <article class="bg-white shadow-sm rounded-lg overflow-hidden flex flex-col
                                   w-full max-w-sm">
                        {{-- Image fixed height --}}
                        @if($item->image_path)
                            <img
                                src="{{ asset('storage/' . $item->image_path) }}"
                                alt="{{ $item->title }}"
                                class="w-full h-40 object-cover object-center"
                                loading="lazy"
                            >
                        @else
                            <div class="w-full h-40 bg-gray-100"></div>
                        @endif

                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="text-base font-semibold leading-snug">
                                <a href="{{ route('news.show', $item) }}" class="hover:underline">
                                    {{ $item->title }}
                                </a>
                            </h3>

                            <p class="text-xs text-gray-500 mt-1">
                                {{ optional($item->published_at)->format('d-m-Y') }}
                            </p>

                            @if($item->excerpt)
                                <p class="text-sm text-gray-700 mt-2 line-clamp-3">
                                    {{ $item->excerpt }}
                                </p>
                            @endif

                            <div class="mt-auto pt-3">
                                <a href="{{ route('news.show', $item) }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                                    {{ __('Read more') }} →
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="text-gray-600">No news yet.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $newsItems->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
