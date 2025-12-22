{{-- resources/views/admin/faq/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create FAQ item') }}
            </h2>

            <a href="{{ route('admin.faq.index') }}"
               class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                ← {{ __('Back to overview') }}
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- Formulier --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    {{ __('FAQ details') }}
                </h3>

                <form method="POST" action="{{ route('admin.faq.store') }}">
                    @csrf

                    {{-- Category --}}
                    <div class="mb-4">
                        <label for="faq_category_id" class="block text-sm font-medium text-gray-700">
                            {{ __('Category') }}
                        </label>
                        <select id="faq_category_id"
                                name="faq_category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('faq_category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('faq_category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Question --}}
                    <div class="mb-4">
                        <label for="question" class="block text-sm font-medium text-gray-700">
                            {{ __('Question') }}
                        </label>
                        <input id="question"
                               name="question"
                               type="text"
                               value="{{ old('question') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('question')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Answer --}}
                    <div class="mb-4">
                        <label for="answer" class="block text-sm font-medium text-gray-700">
                            {{ __('Answer') }}
                        </label>
                        <textarea id="answer"
                                  name="answer"
                                  rows="5"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('answer') }}</textarea>
                        @error('answer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    

                    {{-- Public --}}
                    <div class="mb-6">
                        <label class="inline-flex items-center">
                            <input type="checkbox"
                                   name="is_public"
                                   value="1"
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   {{ old('is_public', true) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">
                                {{ __('Visible for normal users') }}
                            </span>
                        </label>
                        @error('is_public')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>
                            {{ __('Save FAQ') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            {{-- Live preview --}}
            <div
                class="bg-white shadow-sm sm:rounded-lg p-6"
                x-data="{
                    q: @js(old('question')),
                    a: @js(old('answer')),
                }"
            >
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    {{ __('Preview') }}
                </h3>

                <div class="border border-gray-200 rounded-md divide-y">
                    <div class="px-4 py-3 bg-gray-50">
                        <p class="text-sm font-medium text-gray-900" x-text="q || '{{ __('Your question…') }}'"></p>
                    </div>
                    <div class="px-4 py-3">
                        <p class="text-sm text-gray-700 whitespace-pre-line" x-text="a || '{{ __('The answer will appear here.') }}'"></p>
                    </div>
                </div>

                {{-- Kleine hint om preview te updaten via JS --}}
                <script>
                    document.addEventListener('alpine:init', () => {
                        Alpine.effect(() => {
                            const qInput = document.getElementById('question');
                            const aInput = document.getElementById('answer');

                            if (!qInput || !aInput) return;

                            qInput.addEventListener('input', e => { Alpine.store('faqPreview').q = e.target.value; });
                            aInput.addEventListener('input', e => { Alpine.store('faqPreview').a = e.target.value; });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
