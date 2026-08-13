<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('News') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <a href="{{ route('news.index') }}"
               class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#0071bc] mb-6">
                <span aria-hidden="true">&larr;</span> {{ __('Back to all news') }}
            </a>

            <article class="bg-white rounded-xl shadow-sm overflow-hidden">

                {{-- Banner image: height follows the container width, so it can never blow up --}}
                @if($news->image_path)
                    <div class="w-full aspect-video bg-gray-100">
                        <img src="{{ asset('storage/' . $news->image_path) }}"
                             alt="{{ $news->title }}"
                             class="w-full h-full object-cover object-center">
                    </div>
                @endif

                <div class="p-6 sm:p-8">
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">
                        {{ $news->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-gray-500 mt-3 pb-6 border-b border-gray-100">
                        <time datetime="{{ optional($news->published_at)->toDateString() }}">
                            {{ optional($news->published_at)->format('d F Y') }}
                        </time>
                        @if($news->author)
                            <span aria-hidden="true">&middot;</span>
                            <span>{{ $news->author->username ?? $news->author->name ?? $news->author->email }}</span>
                        @endif
                    </div>

                    <div class="mt-6 text-gray-800 leading-relaxed whitespace-pre-line">
                        {{ $news->content }}
                    </div>
                </div>
            </article>

        </div>
    </div>
</x-app-layout>