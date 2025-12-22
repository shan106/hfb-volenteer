<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Frequently Asked Questions') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @forelse($categories as $category)
                @if($category->faqs->count())
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">
                            {{ $category->name }}
                        </h3>

                        <div class="bg-white shadow-sm sm:rounded-lg divide-y">
                            @foreach($category->faqs as $faq)
                                <details class="group">
                                    <summary class="flex justify-between items-center px-4 py-3 cursor-pointer">
                                        <span class="font-medium text-gray-800">
                                            {{ $faq->question }}
                                        </span>
                                        <span class="text-gray-400 group-open:rotate-180 transition-transform">
                                            ▼
                                        </span>
                                    </summary>
                                    <div class="px-4 pb-4 text-sm text-gray-700">
                                        {!! nl2br(e($faq->answer)) !!}
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-gray-500">
                    {{ __('There are no FAQ items yet.') }}
                </p>
            @endforelse
        </div>
    </div>
</x-app-layout>

