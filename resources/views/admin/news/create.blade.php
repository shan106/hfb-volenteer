{{-- resources/views/admin/news/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create News Item') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6"
             x-data="{
                title: @js(old('title')),
                excerpt: @js(old('excerpt')),
                content: @js(old('content')),
                imagePreview: null,

                previewFile(event) {
                    const [file] = event.target.files;
                    if (!file) {
                        this.imagePreview = null;
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = e => this.imagePreview = e.target.result;
                    reader.readAsDataURL(file);
                }
             }">

            {{-- Breadcrumb / teruglink --}}
            <div class="flex items-center text-sm text-gray-500">
                <a href="{{ route('admin.news.index') }}" class="hover:text-gray-700 hover:underline">
                    {{ __('Manage News') }}
                </a>
                <span class="mx-2">/</span>
                <span class="text-gray-700 font-medium">
                    {{ __('New item') }}
                </span>
            </div>

            {{-- Hoofdkaart --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ __('New News Item') }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Voeg een nieuw nieuwsbericht toe voor de HFB vrijwilligers.
                        </p>
                    </div>

                    <a href="{{ route('news.index') }}"
                       target="_blank"
                       class="hidden sm:inline-flex items-center text-xs text-indigo-600 hover:text-indigo-800 underline">
                        {{ __('View public news page') }}
                    </a>
                </div>

                <div class="px-6 py-6">
                    @if ($errors->any())
                        <div class="mb-4 rounded-md bg-red-50 p-4 border border-red-200">
                            <h4 class="text-sm font-semibold text-red-800 mb-1">
                                {{ __('There were some problems with your input:') }}
                            </h4>
                            <ul class="text-xs text-red-700 list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post"
                          action="{{ route('admin.news.store') }}"
                          enctype="multipart/form-data"
                          class="space-y-6">
                        @csrf

                        {{-- Titel + samenvatting in grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6">
                            <div>
                                <x-input-label for="title" value="{{ __('Title') }}" />
                                <x-text-input id="title"
                                              name="title"
                                              type="text"
                                              class="mt-1 block w-full"
                                              x-model="title"
                                              required
                                              placeholder="HFB volunteers support local foodbank" />
                                <p class="mt-1 text-xs text-gray-500">
                                    Een duidelijke, korte titel. Dit is wat mensen als eerste zien.
                                </p>
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="excerpt" value="{{ __('Short summary') }}" />
                                <textarea id="excerpt"
                                          name="excerpt"
                                          rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm"
                                          x-model="excerpt"
                                          placeholder="Korte samenvatting die op de overzichtspagina getoond wordt..."></textarea>
                                <p class="mt-1 text-xs text-gray-500">
                                    Optioneel, max. 500 tekens. Als je dit leeg laat, maken we automatisch een samenvatting.
                                </p>
                                <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Content --}}
                        <div>
                            <x-input-label for="content" value="{{ __('Full content') }}" />
                            <textarea id="content"
                                      name="content"
                                      rows="10"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm"
                                      x-model="content"
                                      placeholder="Schrijf hier het volledige nieuwsbericht. Je kan paragrafen maken, details over het project, aantal geholpen mensen, enz."></textarea>
                            <p class="mt-1 text-xs text-gray-500">
                                Gebruik duidelijke alinea’s. Dit wordt getoond op de detailpagina van het nieuwsitem.
                            </p>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        {{-- Afbeelding + live preview --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6 items-start">
                            <div>
                                <x-input-label for="image" value="{{ __('Header image') }}" />
                                <input id="image"
                                       name="image"
                                       type="file"
                                       class="mt-1 block w-full text-sm"
                                       accept="image/*"
                                       @change="previewFile($event)" />
                                <p class="mt-1 text-xs text-gray-500">
                                    Optioneel. Gebruik een liggende foto (bijv. 16:9). Max. 4 MB.
                                </p>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>

                            {{-- Live preview card --}}
                            <div class="mt-4 md:mt-0">
                                <p class="text-xs font-semibold text-gray-500 mb-2">
                                    {{ __('Live preview') }}
                                </p>
                                <div class="border border-gray-200 rounded-lg p-3 text-xs text-gray-500 bg-gray-50">
                                    {{-- Image preview --}}
                                    <template x-if="imagePreview">
                                        <img :src="imagePreview"
                                             alt="Preview image"
                                             class="h-24 w-full object-cover rounded mb-2">
                                    </template>
                                    <template x-if="!imagePreview">
                                        <div class="h-24 bg-gray-200 rounded mb-2 flex items-center justify-center text-[10px] text-gray-600">
                                            {{ __('News image preview') }}
                                        </div>
                                    </template>

                                    {{-- Title --}}
                                    <p class="font-semibold text-gray-800"
                                       x-text="title || '{{ __('Example title of your news item') }}'">
                                    </p>

                                    {{-- Date + meta --}}
                                    <p class="text-[11px] text-gray-500 mt-1">
                                        {{ now()->format('d-m-Y') }} · Humanity First Belgium
                                    </p>

                                    {{-- Excerpt / summary --}}
                                    <p class="text-[11px] text-gray-600 mt-2"
                                       x-text="excerpt || '{{ __('Short summary of the article will appear here on the overview page...') }}'">
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Acties --}}
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.news.index') }}"
                               class="text-sm text-gray-500 hover:text-gray-700 hover:underline">
                                {{ __('Cancel and go back') }}
                            </a>

                            <x-primary-button>
                                {{ __('Publish news item') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
