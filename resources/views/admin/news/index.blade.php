<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage News') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                <h3 class="text-lg font-semibold">News items</h3>
                <a href="{{ route('admin.news.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">
                    + {{ __('New item') }}
                </a>
            </div>

            @if(session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($newsItems->count())
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">Title</th>
                                    <th class="text-left py-2">Published at</th>
                                    <th class="text-right py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($newsItems as $item)
                                    <tr class="border-b">
                                        <td class="py-2">
                                            <a href="{{ route('news.show', $item) }}" class="text-indigo-600 hover:underline" target="_blank">
                                                {{ $item->title }}
                                            </a>
                                        </td>
                                        <td class="py-2">
                                            {{ optional($item->published_at)->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="py-2 text-right space-x-2">
                                            <a href="{{ route('admin.news.edit', $item) }}" class="text-sm text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('admin.news.destroy', $item) }}" method="post" class="inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="text-sm text-red-600 hover:underline" onclick="return confirm('Delete this item?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $newsItems->links() }}
                        </div>
                    @else
                        <p>No news items yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
