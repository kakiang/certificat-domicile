<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">
            <div class="pb-6 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Détails de la demande #{{ $certificat->numero_certificat }}
                    </h1>
                    @php
                        $statusClass =
                            [
                                'En attente' => 'bg-yellow-100 text-yellow-800',
                                'En cours de traitement' => 'bg-blue-100 text-blue-800',
                                'Incomplète' => 'bg-red-100 text-red-800',
                                'Délivré' => 'bg-green-100 text-green-800',
                                'Rejété' => 'bg-red-100 text-red-500',
                            ][$certificat->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 text-md font-bold rounded-full {{ $statusClass }}">
                        {{ $certificat->status }}
                    </span>
                </div>
                @if ($certificat->status === 'Délivré')
                    <a href="{{ route('certificats.print', $certificat) }}" target="_blank">
                        <i
                            class="fa-solid fa-file-circle-plus text-3xl text-indigo-600 cursor-pointer hover:text-indigo-800 transition-colors duration-200"></i>
                    </a>
                @endif
            </div>

            <div class="px-6 py-6 space-y-6">
                <h3 class="text-lg font-semibold text-gray-700 pb-2 border-b border-gray-200">Informations du Demandeur
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Nom & Prénoms</p>
                        <p class="font-bold text-gray-900">{{ $certificat->habitant->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Date de naissance</p>
                        <p class="font-bold text-gray-900">
                            {{ \Carbon\Carbon::parse($certificat->habitant->date_naissance)->format('d/m/Y') }}</p>
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

                <h3 class="text-lg font-semibold text-gray-700 mt-8 pb-2 border-b border-gray-200">Documents Fournis
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Pièce d'identité</p>
                        @if ($certificat->piece_identite_file_path)
                            <a href="{{ Storage::url($certificat->piece_identite_file_path) }}" target="_blank"
                                class="text-indigo-600 hover:text-indigo-800 underline font-bold transition-colors duration-200">
                                {{ $certificat->piece_identite_slug }}
                            </a>
                        @else
                            <p class="text-gray-800 font-medium">Non fourni</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 underline">Justificatif de domicile</p>
                        @if ($certificat->justificatif_domicile_file_path)
                            <a href="{{ Storage::url($certificat->justificatif_domicile_file_path) }}" target="_blank"
                                class="text-indigo-600 hover:text-indigo-800 underline font-bold transition-colors duration-200">
                                {{ $certificat->justificatif_domicile_slug }}
                            </a>
                        @else
                            <p class="text-gray-800 font-medium">Non fourni</p>
                        @endif
                    </div>
                </div>

                <h3 class="text-lg font-semibold pb-2 border-b border-gray-200">Observations
                </h3>

                <p>
                    {{ $certificat->observation ?? 'Aucune observation' }}</p>

                @if (Auth::user()->is_admin)
                    <form action="{{ route('certificats.update_status', $certificat) }}" method="POST"
                        class="space-y-6 pt-2 border-t border-gray-200">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="status" :value="__('Statut')" />
                                <x-select-input name="status" id="status">
                                    <option value="En attente" @selected($certificat->status === 'En attente')>En attente</option>
                                    <option value="En cours de traitement" @selected($certificat->status === 'En cours de traitement')>En cours de
                                        traitement</option>
                                    <option value="Incomplète" @selected($certificat->status === 'Incomplète')>Incomplète</option>
                                    <option value="Délivré" @selected($certificat->status === 'Délivré')>Délivré</option>
                                    <option value="Rejété" @selected($certificat->status === 'Rejété')>Rejété</option>
                                </x-select-input>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="observation" :value="__('Observations')" />
                                <textarea id="observation" name="observation" rows="4"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('observation', $certificat->observation) }}</textarea>
                                <x-input-error :messages="$errors->get('observation')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <x-primary-button class="rounded-full">
                                Mettre à jour
                            </x-primary-button>
                        </div>
                    </form>
                @endif
            </div>

            <div class="flex items-center justify-start space-x-4 border-t border-gray-100 py-3 px-6">
                <a href="{{ route('certificats.index') }}"
                    class="px-5 py-2.5 font-medium text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-colors duration-200">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
