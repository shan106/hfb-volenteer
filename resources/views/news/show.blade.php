<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $news->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <article class="bg-white shadow-sm rounded-lg p-6">
                @if($news->image_path)
                    <img src="{{ asset('storage/' . $news->image_path) }}"
                         alt="{{ $news->title }}"
                         class="w-full rounded-md mb-4 object-cover">
                @endif

                <p class="text-sm text-gray-500 mb-4">
                    {{ optional($news->published_at)->format('d-m-Y H:i') }}
                    @if($news->author)
                        · {{ __('by') }} {{ $news->author->username ?? $news->author->name ?? $news->author->email }}
                    @endif
                </p>

                <div class="prose max-w-none">
                    {!! nl2br(e($news->content)) !!}
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
