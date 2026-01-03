<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Users') }}
            </h2>

            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                + New User
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="get" class="flex gap-2">
                    <input name="q" value="{{ $q ?? '' }}" class="w-full border-gray-300 rounded-md"
                           placeholder="Search name / username / email...">
                    <button class="px-4 py-2 bg-gray-800 text-white rounded-md">Search</button>
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="py-2 pr-4">ID</th>
                                <th class="py-2 pr-4">Name</th>
                                <th class="py-2 pr-4">Username</th>
                                <th class="py-2 pr-4">Email</th>
                                <th class="py-2 pr-4">Role</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="border-b last:border-0">
                                    <td class="py-2 pr-4">{{ $user->id }}</td>
                                    <td class="py-2 pr-4">{{ $user->name }}</td>
                                    <td class="py-2 pr-4">{{ $user->username }}</td>
                                    <td class="py-2 pr-4">{{ $user->email }}</td>
                                    <td class="py-2 pr-4">
                                        @if($user->is_admin)
                                            <span class="px-2 py-1 rounded bg-indigo-50 text-indigo-700">Admin</span>
                                        @else
                                            <span class="px-2 py-1 rounded bg-gray-50 text-gray-700">User</span>
                                        @endif
                                    </td>
                                    <td class="py-2 pr-4">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                               class="text-indigo-600 hover:underline">
                                                Edit
                                            </a>

                                            <form method="post" action="{{ route('admin.users.toggleAdmin', $user) }}">
                                                @csrf
                                                <button class="text-gray-700 hover:underline"
                                                    onclick="return confirm('Toggle admin rights for this user?')">
                                                    Toggle Admin
                                                </button>
                                            </form>

                                            <form method="post" action="{{ route('admin.users.destroy', $user) }}">
                                                @csrf
                                                @method('delete')
                                                <button class="text-red-600 hover:underline"
                                                    onclick="return confirm('Delete this user?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if($users->count() === 0)
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-gray-600">No users found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="p-4">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
xw