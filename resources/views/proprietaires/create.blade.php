<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">

            <div class="pb-6 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900">
                    Inscription du propriétaire
                </h1>
                <p class="mt-2 text-gray-500">
                    Veuillez remplir le formulaire ci-dessous pour créer un nouveau compte propriétaire.
                </p>
            </div>

            <form action="{{ route('proprietaires.store') }}" method="POST" class="mt-8 space-y-6">
                @csrf
                
                <!-- Conteneur de la grille pour afficher 2 inputs par ligne -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="nom" :value="__('Nom')" />
                        <x-text-input id="nom" name="nom" type="text" :value="old('nom')" autofocus
                            autocomplete="nom" />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="prenom" :value="__('Prenoms')" />
                        <x-text-input id="prenom" name="prenom" type="text" :value="old('prenom')" autofocus
                            autocomplete="prenom" />
                        <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="telephone" :value="__('Telephone')" />
                        <x-text-input id="telephone" name="telephone" type="tel" :value="old('telephone')" autofocus
                            autocomplete="telephone" />
                        <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                    </div>
                    
                    <div>
                        <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                        <x-text-input id="date_naissance" name="date_naissance" type="date" :value="old('date_naissance')" autofocus
                            autocomplete="date_naissance" />
                        <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="lieu_naissance" :value="__('Lieu de naissance')" />
                        <x-text-input id="lieu_naissance" name="lieu_naissance" type="text" :value="old('lieu_naissance')" autofocus
                            autocomplete="lieu_naissance" />
                        <x-input-error :messages="$errors->get('lieu_naissance')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('proprietaires.index') }}"
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
