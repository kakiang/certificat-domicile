<x-app-layout>

    <div class="max-w-4xl mx-auto py-4">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-blue-500">
                <h2 class="text-xl font-semibold text-white">Ajouter un nouveau quartier</h2>
            </div>
            <form action="{{ route('quartiers.store') }}" method="POST" class="px-6 py-6">
                @csrf

                <div>
                    <x-input-label for="nom" :value="__('Nom')" />
                    <x-text-input id="nom" name="nom" type="text" :value="old('nom')" autofocus
                        autocomplete="nom" />
                    <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="description" :value="__('Description')" />
                    <x-text-input id="description" name="description" type="text" :value="old('description')" autofocus
                        autocomplete="description" />
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('quartiers.index') }}"
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
