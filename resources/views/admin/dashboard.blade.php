<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900">
                    Welcome, {{ auth()->user()->username ?? auth()->user()->name }} (Admin)
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    Kies een onderdeel om te beheren.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Manage News --}}
                <a href="{{ route('admin.news.index') }}"
                   class="group bg-white shadow-sm rounded-lg p-6 border hover:border-indigo-300 hover:shadow transition">
                    <div class="flex items-start justify-between">
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 group-hover:text-indigo-700">
                                Manage News
                            </h4>
                            <p class="mt-1 text-sm text-gray-600">
                                Voeg nieuws toe, bewerk of verwijder nieuwsitems.
                            </p>
                        </div>
                        <span class="text-indigo-600 text-xl">→</span>
                    </div>
                </a>

                {{-- Manage FAQ --}}
                <a href="{{ route('admin.faq.index') }}"
                   class="group bg-white shadow-sm rounded-lg p-6 border hover:border-indigo-300 hover:shadow transition">
                    <div class="flex items-start justify-between">
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 group-hover:text-indigo-700">
                                Manage FAQ
                            </h4>
                            <p class="mt-1 text-sm text-gray-600">
                                Beheer FAQ-categorieën en vragen/antwoorden.
                            </p>
                        </div>
                        <span class="text-indigo-600 text-xl">→</span>
                    </div>
                </a>

                {{-- (Optioneel later) Users --}}
                <div class="bg-gray-50 shadow-sm rounded-lg p-6 border">
                    <h4 class="text-base font-semibold text-gray-800">
                        Manage Users (later)
                    </h4>
                    <p class="mt-1 text-sm text-gray-600">
                        Overzicht en adminrechten beheren (kan je later toevoegen).
                    </p>
                </div>

                {{-- (Optioneel later) Contact forms --}}
                <div class="bg-gray-50 shadow-sm rounded-lg p-6 border">
                    <h4 class="text-base font-semibold text-gray-800">
                        Contact Forms (later)
                    </h4>
                    <p class="mt-1 text-sm text-gray-600">
                        Overzicht van berichten en antwoorden via admin panel.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
