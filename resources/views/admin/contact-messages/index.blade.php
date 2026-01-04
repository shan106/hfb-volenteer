{{-- resources/views/admin/contact-messages/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Forms') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if(session('status'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-green-800 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @php
                // controller geeft meestal $status mee, maar als die er niet is: haal uit querystring
                $current = $status ?? request('status'); // null | 'open' | 'replied'
            @endphp

            <div class="bg-white shadow-sm rounded-lg p-6">

                {{-- Filters --}}
                <div class="flex items-center gap-2 mb-6">
                    <a href="{{ route('admin.contact-messages.index') }}"
                       @class([
                           'inline-flex items-center px-4 py-2 rounded-md border text-sm font-medium transition',
                           'bg-indigo-600 text-white border-indigo-600' => $current === null,
                           'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' => $current !== null,
                       ])>
                        All
                    </a>

                    <a href="{{ route('admin.contact-messages.index', ['status' => 'open']) }}"
                       @class([
                           'inline-flex items-center px-4 py-2 rounded-md border text-sm font-medium transition',
                           'bg-indigo-600 text-white border-indigo-600' => $current === 'open',
                           'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' => $current !== 'open',
                       ])>
                        Open
                    </a>

                    <a href="{{ route('admin.contact-messages.index', ['status' => 'replied']) }}"
                       @class([
                           'inline-flex items-center px-4 py-2 rounded-md border text-sm font-medium transition',
                           'bg-indigo-600 text-white border-indigo-600' => $current === 'replied',
                           'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' => $current !== 'replied',
                       ])>
                        Replied
                    </a>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-600 border-b">
                            <tr>
                                <th class="py-3 pr-4">Date</th>
                                <th class="py-3 pr-4">From</th>
                                <th class="py-3 pr-4">Subject</th>
                                <th class="py-3 pr-4">Status</th>
                                <th class="py-3 pr-4">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse($messages as $msg)
                                <tr>
                                    <td class="py-3 pr-4 whitespace-nowrap text-gray-700">
                                        {{ optional($msg->created_at)->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="py-3 pr-4 text-gray-800">
                                        <div class="font-medium">{{ $msg->name ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $msg->email ?? '' }}</div>
                                    </td>

                                    <td class="py-3 pr-4 text-gray-800">
                                        {{ $msg->subject ?? '(No subject)' }}
                                    </td>

                                    <td class="py-3 pr-4">
                                        @if($msg->is_replied)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                Replied
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                                Open
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-3 pr-4">
                                        <a href="{{ route('admin.contact-messages.show', $msg) }}"
                                           class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-gray-500">
                                        No messages.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $messages->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
