<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }} #{{ $user->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6 space-y-4">

                <form method="post" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <x-input-label for="name" value="Name (optional)" />
                        <x-text-input id="name" name="name" class="mt-1 block w-full" value="{{ old('name', $user->name) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="username" value="Username (optional)" />
                        <x-text-input id="username" name="username" class="mt-1 block w-full" value="{{ old('username', $user->username) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('username')" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $user->email) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="pt-2 border-t">
                        <p class="text-sm text-gray-600 mb-2">Laat password leeg als je het niet wil wijzigen.</p>

                        <div>
                            <x-input-label for="password" value="New Password (optional)" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <div class="mt-3">
                            <x-input-label for="password_confirmation" value="Confirm New Password" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <x-primary-button>Save</x-primary-button>
                        <a href="{{ route('admin.users.index') }}" class="text-gray-700 underline">Back</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
