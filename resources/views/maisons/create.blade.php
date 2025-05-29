<x-app-layout>

    <div class="max-w-4xl mx-auto py-4">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-blue-500">
                <h2 class="text-xl font-semibold text-white">Ajouter une nouvelle maison</h2>
            </div>

            <form action="{{ route('maisons.store') }}" method="POST" class="px-6 py-6">
                @csrf

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

                <div class="mt-4">
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

                <div class="mt-4">
                    <x-input-label for="numero" :value="__('Numero de la maison')" />
                    <x-text-input id="numero" name="numero" type="text"
                        :value="old('numero')" autofocus autocomplete="numero" />
                    <x-input-error :messages="$errors->get('numero')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="description" :value="__('Description de la maison')" />
                    <x-text-input id="description" name="description" type="text"
                        :value="old('description')" autofocus autocomplete="description" />
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('maisons.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
                        Annuler
                    </a>
                    <x-primary-button>
                        {{ __('Enregistrer') }}
                    </x-primary-button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
