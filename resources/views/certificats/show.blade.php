<x-app-layout>
    <div class="max-w-4xl mx-auto py-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-blue-500">
                <h2 class="text-xl font-semibold text-white">
                    Détails du certificat
                </h2>
            </div>

            <div class="px-6 py-6 space-y-6">
                <!-- Section Informations du Demandeur -->
                <h3 class="text-lg font-semibold text-gray-700 pb-2 border-b border-gray-200">Informations du Demandeur</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <x-input-label class="underline" :value="__('Nom & Prénoms')" />
                        <p class="font-medium">{{ $certificat->habitant->full_name }}</p>
                    </div>
                    <div>
                        <x-input-label class="underline" :value="__('Date de naissance')" />
                        <p class="font-medium">{{ \Carbon\Carbon::parse($certificat->habitant->date_naissance)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <x-input-label class="underline" :value="__('Lieu de naissance')" />
                        <p class="font-medium">{{ $certificat->habitant->lieu_naissance }}</p>
                    </div>
                    <div>
                        <x-input-label class="underline" :value="__('Téléphone')" />
                        <p class="font-medium">{{ $certificat->habitant->telephone }}</p>
                    </div>
                    <div>
                        <x-input-label class="underline" :value="__('Maison')" />
                        <p class="font-medium">{{ $certificat->habitant->maison->full_name }}</p>
                    </div>
                    <div>
                        <x-input-label class="underline" :value="__('Quartier')" />
                        <p class="font-medium">{{ $certificat->habitant->maison->quartier->nom }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-gray-700 mt-8 pb-2 border-b border-gray-200">Documents Fournis</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label class="underline" :value="__('Pièce d\'identité')" />
                        <p class="text-gray-800 font-medium">{{ $certificat->piece_identite }}</p>
                        @if ($certificat->piece_identite_file_path)
                            <a href="{{ Storage::url($certificat->piece_identite_file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline">
                                {{ $certificat->piece_identite_slug }}
                            </a>
                        @else
                            <p class="text-gray-800 font-medium">Non fourni</p>
                        @endif
                    </div>
                    <div>
                        <x-input-label class="underline" :value="__('Justificatif de domicile')" />
                        <p class="text-gray-800 font-medium">{{ $certificat->justificatif_domicile }}</p>
                        @if ($certificat->justificatif_domicile_file_path)
                            <a href="{{ Storage::url($certificat->justificatif_domicile_file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline">
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
                    class="px-5 py-2.5 font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</x-app-layout>