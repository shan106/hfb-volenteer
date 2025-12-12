<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Latest News') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-2">
                @forelse($newsItems as $item)
                    <article class="bg-white shadow-sm rounded-lg overflow-hidden flex flex-col">
                        @if($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="h-40 w-full object-cover">
                        @endif
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="text-lg font-semibold mb-1">
                                <a href="{{ route('news.show', $item) }}" class="hover:underline">
                                    {{ $item->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-gray-500 mb-2">
                                {{ optional($item->published_at)->format('d-m-Y') }}
                            </p>
                            @if($item->excerpt)
                                <p class="text-sm text-gray-700 flex-1">
                                    {{ $item->excerpt }}
                                </p>
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('news.show', $item) }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                                    {{ __('Read more') }} →
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <p>No news yet.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $newsItems->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
