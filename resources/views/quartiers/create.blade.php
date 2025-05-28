<x-app-layout>
    <x-slot name="header">
        <x-content-nav-bar>
            <x-slot:title>
                Ajouter un nouveau quartier
            </x-slot:title>
            <x-list-link href="{{ route('quartiers.index') }}">
                Lister les quartiers
            </x-list-link>
        </x-content-nav-bar>
    </x-slot>

    <div class="overflow-x-auto py-4">
        <form class="max-w-md mx-auto p-2" action="{{ route('quartiers.store') }}" method="POST">
            @csrf

            <div>
                <x-input-label for="nom" :value="__('Nom')" />
                <x-text-input id="nom" name="nom" type="text" class="block mt-1 w-full" :value="old('nom')"
                    autofocus autocomplete="nom" />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" :value="__('Description')" />
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
