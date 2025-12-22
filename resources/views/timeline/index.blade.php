<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Community Timeline') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Post form (alleen ingelogd) --}}
            @auth
                <div class="bg-white shadow-sm rounded-lg p-6">
                    @if(session('status'))
                        <p class="mb-3 text-sm text-green-600">{{ session('status') }}</p>
                    @endif

                    <form method="post" action="{{ route('timeline.store') }}" enctype="multipart/form-data" class="space-y-3">
                        @csrf

                        <div>
                            <x-input-label for="content" :value="__('Share an update')" />
                            <textarea id="content" name="content" rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                      placeholder="{{ __('What are you working on for Humanity First?') }}">{{ old('content') }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Image (optional)')" />
                            <input id="image" name="image" type="file" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <x-primary-button>{{ __('Post') }}</x-primary-button>
                    </form>
                </div>
            @endauth

            {{-- Timeline posts --}}
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 space-y-6">
                    @forelse($posts as $post)
                        <article class="border-b last:border-0 pb-4 last:pb-0">
                            <div class="flex items-center gap-3 mb-2">
                                @if($post->user->avatar_path)
                                    <img src="{{ asset('storage/' . $post->user->avatar_path) }}"
                                         alt="Avatar"
                                         class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-sm font-semibold">
                                        {{ strtoupper(substr($post->user->username ?? $post->user->name ?? $post->user->email, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('users.show', $post->user) }}" class="font-semibold text-gray-900 hover:underline">
                                        {{ $post->user->username ?? $post->user->name ?? $post->user->email }}
                                    </a>
                                    <p class="text-xs text-gray-500">
                                        {{ $post->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                @auth
                                    @if(auth()->id() === $post->user_id || auth()->user()->is_admin)
                                        <form action="{{ route('timeline.destroy', $post) }}" method="post" class="ml-auto">
                                            @csrf
                                            @method('delete')
                                            <button class="text-xs text-red-600 hover:underline"
                                                    onclick="return confirm('Delete this post?')">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>

                            <p class="text-gray-800 whitespace-pre-line mb-2">
                                {{ $post->content }}
                            </p>

                            @if($post->image_path)
                                <img src="{{ asset('storage/' . $post->image_path) }}"
                                     alt="Post image"
                                     class="max-h-80 rounded-md object-cover">
                            @endif
                        </article>
                    @empty
                        <p class="text-gray-600">{{ __('No posts yet.') }}</p>
                    @endforelse
                </div>

                <div class="px-6 pb-4">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
