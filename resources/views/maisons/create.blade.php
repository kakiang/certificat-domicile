<x-app-layout>
    <x-slot name="header">
        <x-content-nav-bar>
            <x-slot:title>
                Ajouter une nouvelle maison
            </x-slot:title>
            <x-list-link href="{{ route('maisons.index') }}">
                Lister les maisons
            </x-list-link>
        </x-content-nav-bar>
    </x-slot>

    <div class="overflow-x-auto py-4">
        <form class="max-w-md mx-auto p-2" action="{{ route('maisons.store') }}" method="POST">
            @csrf

            <div>
                <x-input-label for="quartier" :value="__('Quartier de la maison')" />
                <x-input-select name="quartier_id" id="quartier_id" class="block mt-1 w-full">
                    <option>Selectionnez</option>
                    @foreach ($quartiers as $quartier)
                        <option value="{{ $quartier->id }}">{{ $quartier->nom }}</option>  
                    @endforeach
                </x-input-select>
                <x-input-error :messages="$errors->get('quartier_id')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="proprietaire" :value="__('Propriétaire de la maison')" />
                <x-input-select name="proprietaire_id" id="proprietaire_id" class="block mt-1 w-full">
                    <option>Selectionnez</option>
                    @foreach ($proprietaires as $proprietaire)
                        <option value="{{ $proprietaire->id }}">{{ $proprietaire->nom . ' ' .  $proprietaire->prenom}}</option>  
                    @endforeach
                </x-input-select>
                <x-input-error :messages="$errors->get('proprietaire_id')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="numero" :value="__('Numero de la maison')" />
                <x-text-input id="numero" name="numero" type="text" class="block mt-1 w-full" :value="old('numero')"
                    autofocus autocomplete="numero" />
                <x-input-error :messages="$errors->get('numero')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" :value="__('Description de la maison')" />
                <x-text-input id="description" name="description" type="text" class="block mt-1 w-full" :value="old('description')"
                    autofocus autocomplete="description" />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
           
            <x-primary-button class="w-full justify-center mt-4">
                {{ __('Enregistrer') }}
            </x-primary-button>

        </form>

    </div>
</x-app-layout>
