<x-app-layout>
    <!-- Le conteneur principal `div` est mis à jour pour correspondre au design de la page "Demandes" -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- La carte de détails utilise le même style moderne avec des coins arrondis et une ombre -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">
            
            <!-- Le titre est mis à jour pour un style plus propre et cohérent -->
            <div class="pb-6 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900">
                    Détails habitant
                </h1>
            </div>

            <div class="mt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Nom</p>
                        <p class="font-bold text-gray-900">{{ $habitant->nom }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Prénoms</p>
                        <p class="font-bold text-gray-900">{{ $habitant->prenom }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Téléphone</p>
                        <p class="font-bold text-gray-900">{{ $habitant->telephone }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Date de naissance</p>
                        <p class="font-bold text-gray-900">
                            {{ \Carbon\Carbon::parse($habitant->date_naissance)->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Lieu de naissance</p>
                        <p class="font-bold text-gray-900">{{ $habitant->lieu_naissance }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Maison</p>
                        <p class="font-bold text-gray-900">
                            @if ($habitant->maison)
                                {{ $habitant->maison->full_name }}
                            @else
                                Non attribuée
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Email</p>
                        <p class="font-bold text-gray-900">{{ $habitant->user?->email ?? '--' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Inscrit le</p>
                        <p class="font-bold text-gray-900">
                            {{ \Carbon\Carbon::parse($habitant->created_at)->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Dernière mise à jour</p>
                        <p class="font-bold text-gray-900">
                            {{ \Carbon\Carbon::parse($habitant->updated_at)->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between border-t border-gray-100 pt-6 mt-6">
                <a href="{{ route('habitants.index') }}"
                    class="px-5 py-2.5 font-medium text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-colors duration-200">
                    Retour à la liste
                </a>
                @can('update', $habitant)
                    <a href="{{ route('habitants.edit', $habitant) }}"
                        class="px-5 py-2.5 font-medium text-white bg-indigo-600 rounded-full hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                        Modifier
                    </a>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
