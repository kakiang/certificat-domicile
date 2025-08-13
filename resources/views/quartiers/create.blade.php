<x-app-layout>
    <!-- Le conteneur principal `div` a été mis à jour pour correspondre au design des autres pages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- La carte du formulaire utilise le même style moderne que les autres pages -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">

            <!-- Le titre est mis à jour pour un style plus propre et cohérent -->
            <div class="pb-6 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900">
                    Ajouter un nouveau quartier
                </h1>
                <p class="mt-2 text-gray-500">
                    Remplissez les informations ci-dessous pour enregistrer un nouveau quartier.
                </p>
            </div>

            <form action="{{ route('quartiers.store') }}" method="POST" class="mt-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="nom" :value="__('Nom')" />
                        <x-text-input id="nom" name="nom" type="text" :value="old('nom')" autofocus
                            autocomplete="nom" />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="4"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('quartiers.index') }}"
                        class="px-5 py-2.5 font-medium text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-colors duration-200">
                        Annuler
                    </a>
                    <x-primary-button class="rounded-full">
                        Enregistrer
                    </x-primary-button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
