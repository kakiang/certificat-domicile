<x-app-layout>

    <div class="max-w-4xl mx-auto py-4">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-blue-500">
                <h2 class="text-xl font-semibold text-white">Ajouter un propriétaire</h2>
            </div>

            <form action="{{ route('proprietaires.store') }}" method="POST" class="px-6 py-6">
                @csrf

                <div>
                    <x-input-label for="nom" :value="__('Nom')" />
                    <x-text-input id="nom" name="nom" type="text" :value="old('nom')" autofocus
                        autocomplete="nom" />
                    <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="prenom" :value="__('Prenoms')" />
                    <x-text-input id="prenom" name="prenom" type="text" :value="old('prenom')" autofocus
                        autocomplete="prenom" />
                    <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="telephone" :value="__('Telephone')" />
                    <x-text-input id="telephone" name="telephone" type="tel" :value="old('telephone')" autofocus
                        autocomplete="telephone" />
                    <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                    <x-text-input id="date_naissance" name="date_naissance" type="date" :value="old('date_naissance')" autofocus
                        autocomplete="date_naissance" />
                    <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="lieu_naissance" :value="__('Lieu de naissance')" />
                    <x-text-input id="lieu_naissance" name="lieu_naissance" type="text" :value="old('lieu_naissance')" autofocus
                        autocomplete="lieu_naissance" />
                    <x-input-error :messages="$errors->get('lieu_naissance')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('proprietaires.index') }}"
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
