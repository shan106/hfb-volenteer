<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Latest News') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($newsItems->count())
                @php
                    $items    = $newsItems->getCollection();
                    $featured = $items->first();
                    $rest     = $items->slice(1);
                @endphp

                {{-- Featured story --}}
                <article class="bg-white rounded-xl shadow-sm overflow-hidden mb-10 grid md:grid-cols-2">
                    <a href="{{ route('news.show', $featured) }}" class="block bg-gray-100">
                        @if($featured->image_path)
                            <img src="{{ asset('storage/' . $featured->image_path) }}"
                                 alt="{{ $featured->title }}"
                                 class="w-full h-56 md:h-full md:min-h-64 object-cover object-center">
                        @else
                            <div class="w-full h-56 md:h-full md:min-h-64 bg-gray-100"></div>
                        @endif
                    </a>

                    <div class="p-6 md:p-8 flex flex-col justify-center">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[#0071bc] mb-2">
                            {{ __('Featured') }}
                        </p>

                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">
                            <a href="{{ route('news.show', $featured) }}" class="hover:text-[#0071bc]">
                                {{ $featured->title }}
                            </a>
                        </h3>

                        <p class="text-sm text-gray-500 mt-2">
                            {{ optional($featured->published_at)->format('d F Y') }}
                            @if($featured->author)
                                &middot; {{ $featured->author->username ?? $featured->author->name }}
                            @endif
                            &middot; {{ trans_choice('{0}No comments|{1}1 comment|[2,*]:count comments', $featured->comments_count, ['count' => $featured->comments_count]) }}
                        </p>

                        @if($featured->excerpt)
                            <p class="text-gray-700 mt-4 leading-relaxed">
                                {{ $featured->excerpt }}
                            </p>
                        @endif

                        <div class="mt-6">
                            <a href="{{ route('news.show', $featured) }}"
                               class="inline-flex items-center gap-2 text-sm font-semibold text-[#0071bc] hover:underline">
                                {{ __('Read the full story') }} <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </article>

                {{-- Remaining stories --}}
                @if($rest->count())
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">
                        {{ __('More news') }}
                    </h3>

                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($rest as $item)
                            <article class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                                <a href="{{ route('news.show', $item) }}" class="block">
                                    @if($item->image_path)
                                        <img src="{{ asset('storage/' . $item->image_path) }}"
                                             alt="{{ $item->title }}"
                                             class="w-full h-44 object-cover object-center"
                                             loading="lazy">
                                    @else
                                        <div class="w-full h-44 bg-gray-100"></div>
                                    @endif
                                </a>

                                <div class="p-5 flex flex-col flex-1">
                                    <p class="text-xs text-gray-500">
                                        {{ optional($item->published_at)->format('d F Y') }}
                                        &middot; {{ trans_choice('{0}No comments|{1}1 comment|[2,*]:count comments', $item->comments_count, ['count' => $item->comments_count]) }}
                                    </p>

                                    <h4 class="text-lg font-semibold text-gray-900 leading-snug mt-1">
                                        <a href="{{ route('news.show', $item) }}" class="hover:text-[#0071bc]">
                                            {{ $item->title }}
                                        </a>
                                    </h4>

                                    @if($item->excerpt)
                                        <p class="text-sm text-gray-600 mt-2 leading-relaxed line-clamp-3">
                                            {{ $item->excerpt }}
                                        </p>
                                    @endif

                                    <div class="mt-auto pt-4">
                                        <a href="{{ route('news.show', $item) }}"
                                           class="text-sm font-semibold text-[#0071bc] hover:underline">
                                            {{ __('Read more') }} &rarr;
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

                <div class="mt-10">
                    {{ $newsItems->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                    <p class="text-gray-900 font-semibold">{{ __('No news yet') }}</p>
                    <p class="text-gray-600 text-sm mt-1">
                        {{ __('New stories from our volunteers and projects will appear here.') }}
                    </p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>