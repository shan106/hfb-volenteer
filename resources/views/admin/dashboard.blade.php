<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">
                        Welcome, {{ auth()->user()->name ?? auth()->user()->email }} (Admin)
                    </h3>

                    <p class="mb-2">
                        Dit is het beheerspaneel voor Humanity First Belgium.
                    </p>

                    <ul class="list-disc pl-5 space-y-1">
                        <li>Hier komt later: beheer van gebruikers (vrijwilligers).</li>
                        <li>Beheer van nieuws / projecten.</li>
                        <li>Beheer van FAQ-categorieën & vragen.</li>
                        <li>Overzicht van contactformulieren.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
