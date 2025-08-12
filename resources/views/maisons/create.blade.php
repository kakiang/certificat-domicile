<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">

            <div class="pb-6 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900">
                    Ajouter une nouvelle maison
                </h1>
                <p class="mt-2 text-gray-500">
                    Remplissez les informations ci-dessous pour enregistrer une nouvelle maison.
                </p>
            </div>

            <form action="{{ route('maisons.store') }}" method="POST" class="mt-8 space-y-6">
                @csrf

                <!-- Conteneur de la grille pour afficher 2 inputs par ligne -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="quartier" :value="__('Quartier de la maison')" />
                        <x-select-input name="quartier_id" id="quartier_id">
                            <option value="">Selectionnez</option>
                            @foreach ($quartiers as $quartier)
                                <option value="{{ $quartier->id }}"
                                    {{ old('quartier_id') == $quartier->id ? 'selected' : '' }}>
                                    {{ $quartier->nom }}
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('quartier_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="proprietaire_id" :value="__('Propriétaire de la maison')" />
                        <x-select-input name="proprietaire_id" id="proprietaire_id">
                            <option value="">Selectionnez</option>
                            @foreach ($proprietaires as $proprietaire)
                                <option value="{{ $proprietaire->id }}"
                                    {{ old('proprietaire_id') == $proprietaire->id ? 'selected' : '' }}>
                                    {{ $proprietaire->nom . ' ' . $proprietaire->prenom }}
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('proprietaire_id')" class="mt-2" />
                    </div>
                </div>

                <!-- Autre conteneur de la grille pour la suite des champs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="numero" :value="__('Numero de la maison')" />
                        <x-text-input id="numero" name="numero" type="text"
                            :value="old('numero')" autofocus autocomplete="numero" />
                        <x-input-error :messages="$errors->get('numero')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description de la maison')" />
                        <x-text-input id="description" name="description" type="text"
                            :value="old('description')" autofocus autocomplete="description" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('maisons.index') }}"
                        class="px-5 py-2.5 font-medium text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-colors duration-200">
                        Annuler
                    </a>
                    <x-primary-button class="rounded-full">
                        {{ __('Enregistrer') }}
                    </x-primary-button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
