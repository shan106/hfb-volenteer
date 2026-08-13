<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Humanity First Belgium</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
    {{-- Top bar --}}
    <header class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-xl bg-red-600"></div>
                <div>
                    <p class="font-semibold leading-tight">Humanity First Belgium</p>
                    <p class="text-sm text-gray-600">Volunteer Platform</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-xl bg-gray-900 text-white text-sm hover:bg-gray-800 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                    class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-black shadow-sm hover:bg-gray-50 transition">
                        Log in
                    </a>

                    <a href="{{ route('register') }}"
                    class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-black shadow-sm hover:bg-gray-50 transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Content --}}
    <main class="max-w-6xl mx-auto px-6 py-10 space-y-10">

        {{-- Flash success --}}
        @if(session('status'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-900">
                {{ session('status') }}
            </div>
        @endif

        {{-- Page title --}}
        <section class="bg-white border rounded-2xl p-6">
            <h1 class="text-2xl md:text-3xl font-bold">Welcome</h1>
            <p class="mt-2 text-gray-600">
                Bekijk onze laatste updates, veelgestelde vragen en stuur ons een bericht.
            </p>
        </section>

        {{-- Grid: News + FAQ --}}
        <section class="grid md:grid-cols-2 gap-6">
            {{-- Latest News --}}
            <div class="bg-white border rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Latest News</h2>

                    {{-- Als /news publiek is, kan je dit linken. Anders mag je dit weglaten. --}}
                    <a href="{{ url('/news') }}" class="text-sm text-gray-700 hover:underline">
                        View all
                    </a>
                </div>

                <div class="mt-5 space-y-4">
                    @forelse($latestNews as $item)
                        <article class="border rounded-xl p-4 hover:bg-gray-50 transition">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold leading-snug">
                                        {{-- Als /news achter login zit en je wil geen errors: zet dit om naar plain tekst --}}
                                        <a class="hover:underline"
                                           href="{{ url('/news/'.$item->slug) }}">
                                            {{ $item->title }}
                                        </a>
                                    </p>

                                    @if(!empty($item->published_at))
                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($item->published_at)->format('d/m/Y') }}
                                        </p>
                                    @endif

                                    @if(!empty($item->excerpt))
                                        <p class="mt-2 text-sm text-gray-700">
                                            {{ $item->excerpt }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="text-gray-600">Nog geen nieuwsberichten.</p>
                    @endforelse
                </div>
            </div>

            {{-- FAQ --}}
            <div class="bg-white border rounded-2xl p-6">
                <h2 class="text-xl font-semibold">FAQ</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Klik om een antwoord te zien.
                </p>

                <div class="mt-5 space-y-4">
                    @forelse($faqCategories as $category)
                        <div class="border rounded-xl p-4">
                            <p class="font-semibold">{{ $category->name }}</p>

                            <div class="mt-3 space-y-2">
                                @forelse($category->faqs as $faq)
                                    <details class="group border rounded-xl px-4 py-3">
                                        <summary class="cursor-pointer list-none flex items-center justify-between">
                                            <span class="font-medium">{{ $faq->question }}</span>
                                            <span class="text-gray-500 group-open:rotate-180 transition">⌄</span>
                                        </summary>
                                        <div class="mt-2 text-sm text-gray-700 leading-relaxed">
                                            {!! nl2br(e($faq->answer)) !!}
                                        </div>
                                    </details>
                                @empty
                                    <p class="text-sm text-gray-600">Geen vragen in deze categorie.</p>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600">Nog geen FAQ items.</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- Aanbevolen vrijwilligers (willekeurige selectie) --}}
        @if($recommendedVolunteers->count())
            <section class="bg-white border rounded-2xl p-6">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold">Ontmoet onze vrijwilligers</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Een greep uit de mensen die onze projecten mogelijk maken.
                        </p>
                    </div>

                    <a href="{{ route('users.index') }}"
                       class="shrink-0 text-sm text-gray-700 hover:underline">
                        Bekijk allemaal
                    </a>
                </div>

                {{-- Zoekbalk: stuurt door naar het volledige overzicht --}}
                <form method="get" action="{{ route('users.index') }}" class="mt-5 flex gap-2">
                    <label for="home-volunteer-search" class="sr-only">Zoek een vrijwilliger</label>
                    <input
                        id="home-volunteer-search"
                        name="q"
                        type="search"
                        placeholder="Zoek een vrijwilliger op naam"
                        class="flex-1 rounded-xl border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900"
                    >
                    <button type="submit"
                            class="rounded-xl bg-gray-900 px-5 py-2 text-sm font-semibold text-white hover:bg-gray-800 transition">
                        Zoeken
                    </button>
                </form>

                <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($recommendedVolunteers as $volunteer)
                        <x-volunteer-card :user="$volunteer" class="border" />
                    @endforeach
                </div>
            </section>
        @endif

        <a href="{{ route('contact.show') }}"
        class="block rounded-xl border bg-white p-6 hover:shadow-sm transition">
            <p class="font-semibold">Contact</p>
            <p class="mt-1 text-sm text-gray-600">Stuur een bericht naar het admin team.</p>
            <p class="mt-4 inline-flex text-sm font-semibold text-gray-900">
                Open contactformulier →
            </p>
        </a>


    </main>

    <footer class="py-10 text-center text-sm text-gray-500">
        © {{ date('Y') }} Humanity First Belgium
    </footer>
</body>
</html>