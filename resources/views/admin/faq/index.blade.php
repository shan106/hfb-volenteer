<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage FAQ') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-100">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-2 rounded">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Categorieën beheren --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">
                    {{ __('FAQ categories') }}
                </h3>

                <form action="{{ route('admin.faq.categories.store') }}" method="post" class="flex flex-wrap items-end gap-3 mb-4">
                    @csrf
                    <div>
                        <x-input-label for="name" value="{{ __('New category name') }}" />
                        <x-text-input id="name" name="name" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="sort_order" value="{{ __('Sort order') }}" />
                        <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 w-24" value="0" />
                    </div>
                    <div class="pt-5">
                        <x-primary-button>{{ __('Add category') }}</x-primary-button>
                    </div>
                </form>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">ID</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Sort') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr class="border-b">
                                <form action="{{ route('admin.faq.categories.update', $category) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <td class="py-2">{{ $category->id }}</td>
                                    <td>
                                        <input type="text" name="name" value="{{ $category->name }}" class="border-gray-300 rounded w-full text-sm">
                                    </td>
                                    <td>
                                        <input type="number" name="sort_order" value="{{ $category->sort_order }}" class="border-gray-300 rounded w-20 text-sm">
                                    </td>
                                    <td class="text-right space-x-1">
                                        <x-primary-button class="!py-1 !px-3 text-xs">{{ __('Save') }}</x-primary-button>
                                </form>
                                        <form action="{{ route('admin.faq.categories.destroy', $category) }}" method="post" class="inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                    onclick="return confirm('Delete this category? All FAQ in it will also be deleted.')"
                                                    class="text-xs text-red-600 hover:underline">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- FAQ items overzicht + knop naar create --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">
                        {{ __('FAQ items') }}
                    </h3>
                    <a href="{{ route('admin.faq.create') }}">
                        <x-primary-button type="button">+ {{ __('New FAQ') }}</x-primary-button>
                    </a>
                </div>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">ID</th>
                            <th>{{ __('Question') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Public') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $faq)
                            <tr class="border-b">
                                <td class="py-2">{{ $faq->id }}</td>
                                <td>{{ $faq->question }}</td>
                                <td>{{ $faq->category?->name }}</td>
                                <td>{{ $faq->is_public ? 'Yes' : 'No' }}</td>
                                <td class="text-right space-x-2">
                                    <a href="{{ route('admin.faq.edit', $faq) }}" class="text-xs text-indigo-600 hover:underline">
                                        {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('admin.faq.destroy', $faq) }}" method="post" class="inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                                onclick="return confirm('Delete this FAQ?')"
                                                class="text-xs text-red-600 hover:underline">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-4 text-gray-500" colspan="5">
                                    {{ __('No FAQ items yet.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
