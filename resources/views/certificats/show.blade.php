<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">
            <div class="pb-6 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900">
                    Détails de la demande
                </h1>
                <p class="mt-2 text-gray-500">
                    Consultez les informations et le statut de votre demande de certificat.
                </p>
            </div>

            <div class="px-6 py-6 space-y-6">
                <!-- Section Informations du Demandeur -->
                <h3 class="text-lg font-semibold text-gray-700 pb-2 border-b border-gray-200">Informations du Demandeur</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Nom & Prénoms</p>
                        <p class="font-bold text-gray-900">{{ $certificat->habitant->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Date de naissance</p>
                        <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($certificat->habitant->date_naissance)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Lieu de naissance</p>
                        <p class="font-bold text-gray-900">{{ $certificat->habitant->lieu_naissance }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Téléphone</p>
                        <p class="font-bold text-gray-900">{{ $certificat->habitant->telephone }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Maison</p>
                        <p class="font-bold text-gray-900">{{ $certificat->habitant->maison->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Quartier</p>
                        <p class="font-bold text-gray-900">{{ $certificat->habitant->maison->quartier->nom }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-gray-700 mt-8 pb-2 border-b border-gray-200">Documents Fournis</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Pièce d'identité</p>
                        @if ($certificat->piece_identite_file_path)
                            <a href="{{ Storage::url($certificat->piece_identite_file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline font-bold transition-colors duration-200">
                                {{ $certificat->piece_identite_slug }}
                            </a>
                        @else
                            <p class="text-gray-800 font-medium">Non fourni</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Justificatif de domicile</p>
                        @if ($certificat->justificatif_domicile_file_path)
                            <a href="{{ Storage::url($certificat->justificatif_domicile_file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline font-bold transition-colors duration-200">
                               {{ $certificat->justificatif_domicile_slug }}
                            </a>
                        @else
                            <p class="text-gray-800 font-medium">Non fourni</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 border-t border-gray-100 py-3 px-6">
                <a href="{{ route('certificats.index') }}"
                    class="px-5 py-2.5 font-medium text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-colors duration-200">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</x-app-layout>