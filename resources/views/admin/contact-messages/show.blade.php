<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Message') }} #{{ $contactMessage->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-sm text-gray-600">From</div>
                        <div class="font-semibold text-gray-900">
                            {{ $contactMessage->name ?? '—' }} ({{ $contactMessage->email }})
                        </div>
                        <div class="text-sm text-gray-600 mt-2">Subject</div>
                        <div class="font-medium text-gray-900">
                            {{ $contactMessage->subject ?? 'Contact form' }}
                        </div>
                        <div class="text-xs text-gray-500 mt-2">
                            Sent: {{ $contactMessage->created_at->format('Y-m-d H:i') }}
                        </div>
                    </div>

                    @if($contactMessage->is_replied)
                        <span class="px-2 py-1 rounded bg-green-50 text-green-700">Replied</span>
                    @else
                        <span class="px-2 py-1 rounded bg-yellow-50 text-yellow-800">Open</span>
                    @endif
                </div>

                <div class="mt-6">
                    <div class="text-sm text-gray-600 mb-2">Message</div>
                    <div class="whitespace-pre-line text-gray-900 border rounded p-4 bg-gray-50">
                        {{ $contactMessage->message }}
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-gray-900 mb-3">Reply</h3>

                <form method="post" action="{{ route('admin.contact-messages.reply', $contactMessage) }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="reply_subject" value="Reply subject" />
                        <x-text-input id="reply_subject" name="reply_subject" class="mt-1 block w-full"
                                      value="{{ old('reply_subject', 'Re: ' . ($contactMessage->subject ?? 'Your message')) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('reply_subject')" />
                    </div>

                    <div>
                        <x-input-label for="reply_message" value="Reply message" />
                        <textarea id="reply_message" name="reply_message" rows="6"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('reply_message') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('reply_message')" />
                    </div>

                    <x-primary-button>Send reply</x-primary-button>

                    <a class="ml-3 text-gray-700 underline" href="{{ route('admin.contact-messages.index') }}">
                        Back
                    </a>
                </form>

                @if($contactMessage->is_replied)
                    <p class="text-xs text-gray-500 mt-4">
                        Replied at {{ optional($contactMessage->replied_at)->format('Y-m-d H:i') }}
                        by {{ $contactMessage->replied_by }}
                    </p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
