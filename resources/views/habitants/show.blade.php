<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">
            <div class="pb-2 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">
                        Détails de l'habitant
                    </h1>
                </div>
                @can('update', $habitant)
                    <a href="{{ route('habitants.edit', $habitant) }}"
                        class="px-6 py-3 font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition-all duration-200 ease-in-out shadow-md hover:shadow-lg">
                        <i class="fas fa-edit mr-2"></i> Modifier
                    </a>
                @endcan
            </div>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-2xl">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">
                        Informations personnelles
                    </h2>
                    <div class="space-y-5">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nom & Prénoms</p>
                            <p class="font-bold text-gray-900">{{ $habitant->nom }} {{ $habitant->prenom }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date & Lieu de naissance</p>
                            <p class="font-bold text-gray-900">Né(e) le {{ $habitant->date_naissance->format('d/m/Y') }}
                                à {{ $habitant->lieu_naissance }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Téléphone</p>
                            <p class="font-bold text-gray-900">{{ $habitant->telephone }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="font-bold text-gray-900">{{ $habitant->user?->email ?? '--' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">
                        Adresse et Domicile
                    </h2>
                    <div class="space-y-5">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Adresse</p>
                            <p class="font-bold text-gray-900">{{ $habitant->maison->adresse }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Maison</p>
                            <p class="font-bold text-gray-900">
                                {{ $habitant->maison->full_name }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Quartier</p>
                            <p class="font-bold text-gray-900">{{ $habitant->maison->quartier->nom }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">
                        Historique
                    </h2>
                    <div class="space-y-5">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Inscrit le</p>
                            <p class="font-bold text-gray-900">{{ $habitant->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Dernière mise à jour</p>
                            <p class="font-bold text-gray-900">{{ $habitant->updated_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if (Auth::user()->is_admin)
                <div class="border-t border-gray-100 pt-6 mt-8 flex justify-end">
                    <a href="{{ route('habitants.index') }}"
                        class="px-6 py-3 font-semibold text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-colors duration-200">
                        Retour à la liste
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
