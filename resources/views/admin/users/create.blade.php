<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6 space-y-4">

                <form method="post" action="{{ route('admin.users.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Name (optional)" />
                        <x-text-input id="name" name="name" class="mt-1 block w-full" value="{{ old('name') }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="username" value="Username (optional)" />
                        <x-text-input id="username" name="username" class="mt-1 block w-full" value="{{ old('username') }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('username')" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email') }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Password" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Confirm Password" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                    </div>

                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="is_admin" value="1" class="rounded border-gray-300">
                        <span class="text-sm text-gray-700">Make this user admin</span>
                    </label>

                    <div class="flex gap-3">
                        <x-primary-button>Create</x-primary-button>
                        <a href="{{ route('admin.users.index') }}" class="text-gray-700 underline">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
