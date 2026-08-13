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

            {{-- Reacties --}}
            <section class="mt-8" id="comments">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    {{ trans_choice('{0}No comments yet|{1}1 comment|[2,*]:count comments', $news->comments->count(), ['count' => $news->comments->count()]) }}
                </h2>

                @if(session('status'))
                    <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Reactieformulier --}}
                @auth
                    <form method="POST"
                          action="{{ route('news.comments.store', $news) }}"
                          class="bg-white rounded-xl shadow-sm p-5 mb-6">
                        @csrf

                        <label for="body" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Leave a comment') }}
                        </label>

                        <textarea id="body"
                                  name="body"
                                  rows="3"
                                  required
                                  minlength="2"
                                  maxlength="1000"
                                  placeholder="{{ __('Share your thoughts on this story...') }}"
                                  class="block w-full rounded-lg border-gray-300 shadow-sm
                                         focus:border-[#0071bc] focus:ring-[#0071bc]">{{ old('body') }}</textarea>

                        <x-input-error :messages="$errors->get('body')" class="mt-2" />

                        <div class="mt-3 flex justify-end">
                            <button type="submit"
                                    class="px-5 py-2 rounded-lg bg-[#0071bc] text-white text-sm font-semibold
                                           hover:bg-[#005a96] transition-colors">
                                {{ __('Post comment') }}
                            </button>
                        </div>
                    </form>
                @else
                    <div class="bg-white rounded-xl shadow-sm p-5 mb-6 text-sm text-gray-600">
                        <a href="{{ route('login') }}" class="font-semibold text-[#0071bc] hover:underline">
                            {{ __('Log in') }}
                        </a>
                        {{ __('to leave a comment.') }}
                    </div>
                @endauth

                {{-- Lijst van reacties --}}
                @forelse($news->comments as $comment)
                    @php
                        $commenter = $comment->user;
                        $displayName = $commenter?->username ?? $commenter?->name ?? __('Deleted user');
                    @endphp

                    <article class="bg-white rounded-xl shadow-sm p-5 mb-3 flex gap-4">
                        @if($commenter?->avatar_path)
                            <img src="{{ asset('storage/' . $commenter->avatar_path) }}"
                                 alt="{{ $displayName }}"
                                 class="h-10 w-10 shrink-0 rounded-full object-cover object-center">
                        @else
                            <div class="h-10 w-10 shrink-0 rounded-full bg-[#0071bc]/10 flex items-center
                                        justify-center text-sm font-semibold text-[#0071bc]">
                                {{ strtoupper(mb_substr($displayName, 0, 1)) }}
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <div class="flex items-baseline justify-between gap-3">
                                <p class="font-semibold text-gray-900 text-sm truncate">
                                    @if($commenter)
                                        <a href="{{ route('users.show', $commenter) }}" class="hover:underline">
                                            {{ $displayName }}
                                        </a>
                                    @else
                                        {{ $displayName }}
                                    @endif
                                </p>

                                <time class="text-xs text-gray-500 shrink-0"
                                      datetime="{{ $comment->created_at->toIso8601String() }}">
                                    {{ $comment->created_at->diffForHumans() }}
                                </time>
                            </div>

                            <p class="text-sm text-gray-700 mt-1 whitespace-pre-line">
                                {{ $comment->body }}
                            </p>

                            @auth
                                @if(auth()->user()->is_admin || auth()->id() === $comment->user_id)
                                    <form method="POST"
                                          action="{{ route('news.comments.destroy', [$news, $comment]) }}"
                                          class="mt-2"
                                          onsubmit="return confirm('{{ __('Delete this comment?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:underline">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-gray-500">
                        {{ __('Be the first to share your thoughts.') }}
                    </p>
                @endforelse
            </section>

        </div>
    </div>
</x-app-layout>