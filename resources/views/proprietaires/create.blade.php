<x-app-layout>
    <x-slot name="header">
        <x-content-nav-bar>
            <x-slot:title>
                Ajouter un propriétaire
            </x-slot:title>
            <x-list-link href="{{ route('proprietaires.index') }}">
                Lister les propriétaires
            </x-list-link>
        </x-content-nav-bar>
    </x-slot>

    <div class="overflow-x-auto">
        <form class="max-w-md mx-auto p-2" action="{{ route('proprietaires.store') }}" method="POST">
            @csrf

            <div>
                <x-input-label for="nom" :value="__('Nom')" />
                <x-text-input id="nom" name="nom" type="text" class="block mt-1 w-full" :value="old('nom')"
                    autofocus autocomplete="nom" />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="prenom" :value="__('Prenoms')" />
                <x-text-input id="prenom" name="prenom" type="text" class="block mt-1 w-full" :value="old('prenom')"
                    autofocus autocomplete="prenom" />
                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="telephone" :value="__('Telephone')" />
                <x-text-input id="telephone" name="telephone" type="tel" class="block mt-1 w-full" :value="old('telephone')"
                    autofocus autocomplete="telephone" />
                <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                <x-text-input id="date_naissance" name="date_naissance" type="date" class="block mt-1 w-full"
                    :value="old('date_naissance')" autofocus autocomplete="date_naissance" />
                <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="lieu_naissance" :value="__('Lieu de naissance')" />
                <x-text-input id="lieu_naissance" name="lieu_naissance" type="text" class="block mt-1 w-full"
                    :value="old('lieu_naissance')" autofocus autocomplete="lieu_naissance" />
                <x-input-error :messages="$errors->get('lieu_naissance')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center mt-4">
                {{ __('Enregistrer') }}
            </x-primary-button>

        </form>

    </div>
</x-app-layout>
