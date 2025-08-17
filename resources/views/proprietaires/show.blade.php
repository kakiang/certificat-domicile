<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">
        <div class="pb-6 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-900 leading-tight">
                Détails du propriétaire
            </h1>
            <p class="mt-2 text-gray-500">
                Informations complètes sur {{ $proprietaire->full_name }}.
            </p>
        </div>

        <div class="mt-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                <div>
                    <p class="text-sm font-medium text-gray-500">Nom & Prénoms</p>
                    <p class="mt-1 text-xl font-semibold text-gray-900">{{ $proprietaire->full_name }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Téléphone</p>
                    <p class="mt-1 text-xl font-semibold text-gray-900">{{ $proprietaire->telephone }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Date de naissance</p>
                    <p class="mt-1 text-xl font-semibold text-gray-900">{{ \Carbon\Carbon::parse($proprietaire->date_naissance)->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Lieu de naissance</p>
                    <p class="mt-1 text-xl font-semibold text-gray-900">{{ $proprietaire->lieu_naissance }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Créé le</p>
                    <p class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($proprietaire->created_at)->format('d/m/Y') }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Dernière mise à jour</p>
                    <p class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($proprietaire->updated_at)->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6 mt-8">
            <a href="{{ route('proprietaires.edit', $proprietaire) }}"
                class="px-5 py-2.5 font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition-colors duration-200 shadow-md">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>

            <a href="{{ route('proprietaires.index') }}"
                class="px-5 py-2.5 font-medium text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-colors duration-200">
                Retour à la liste
            </a>
        </div>
    </div>
</div>

</x-app-layout>