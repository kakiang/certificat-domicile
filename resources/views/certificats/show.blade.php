<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-lg border border-gray-100">
            <div
                class="pb-6 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">
                        Demande de certificat
                    </h1>
                    @php
                        $statusClass =
                            [
                                'En attente' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20',
                                'En cours de traitement' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                'Incomplète' => 'bg-gray-50 text-gray-700 ring-gray-600/20',
                                'Délivré' => 'bg-green-50 text-green-700 ring-green-600/20',
                                'Rejété' => 'bg-red-50 text-red-700 ring-red-600/20',
                            ][$certificat->status] ?? 'bg-gray-50 text-gray-700 ring-gray-600/20';
                    @endphp
                    <span
                        class="inline-flex items-center rounded-full px-3 py-1 font-semibold ring-1 ring-inset {{ $statusClass }}">
                        {{ $certificat->status }}
                    </span>
                </div>
                @if ($certificat->status === 'Délivré')
                    <a href="{{ route('certificats.print', $certificat) }}" target="_blank"
                        class="px-5 py-2.5 font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition-all duration-200 ease-in-out shadow-md hover:shadow-lg">
                        <i class="fas fa-print mr-2"></i> Imprimer
                    </a>
                @endif
            </div>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-8">
                    <div class="bg-gray-50 p-6 rounded-2xl">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">
                            Informations du Demandeur
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nom & Prénoms</p>
                                <p class="font-bold text-gray-900">{{ $certificat->habitant->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date de naissance</p>
                                <p class="font-bold text-gray-900">
                                    {{ \Carbon\Carbon::parse($certificat->habitant->date_naissance)->format('d/m/Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Lieu de naissance</p>
                                <p class="font-bold text-gray-900">{{ $certificat->habitant->lieu_naissance }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Téléphone</p>
                                <p class="font-bold text-gray-900">{{ $certificat->habitant->telephone }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Maison</p>
                                <p class="font-bold text-gray-900">{{ $certificat->habitant->maison->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Quartier</p>
                                <p class="font-bold text-gray-900">{{ $certificat->habitant->maison->quartier->nom }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-2xl">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">
                            Documents Fournis
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Pièce d'identité</p>
                                @if ($certificat->piece_identite_file_path)
                                    <a href="{{ route('files.view', ['filePath' => $certificat->piece_identite_file_path]) }}"
                                        target="_blank"
                                        class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
                                        <i class="fas fa-file-alt mr-2"></i> {{ $certificat->piece_identite_slug }}
                                    </a>
                                @else
                                    <p class="text-gray-800 font-medium">Non fourni</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Justificatif de domicile</p>
                                @if ($certificat->justificatif_domicile_file_path)
                                    <a href="{{ route('files.view', ['filePath' => $certificat->justificatif_domicile_file_path]) }}"
                                        target="_blank"
                                        class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
                                        <i class="fas fa-file-alt mr-2"></i>
                                        {{ $certificat->justificatif_domicile_slug }}
                                    </a>
                                @else
                                    <p class="text-gray-800 font-medium">Non fourni</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-gray-50 p-6 rounded-2xl">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">
                            Observations
                        </h2>
                        <p class="text-gray-700">
                            {{ $certificat->observation ?? 'Aucune observation' }}
                        </p>
                    </div>

                    @if (Auth::user()->is_admin)
                        <form action="{{ route('certificats.update_status', $certificat) }}" method="POST"
                            class="bg-gray-50 p-6 rounded-2xl shadow-inner">
                            @csrf
                            @method('PUT')
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                                Mettre à jour le statut
                            </h2>
                            <div class="space-y-5">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                                    <select id="status" name="status"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
                                        <option value="En attente" @selected($certificat->status === 'En attente')>En attente</option>
                                        <option value="En cours de traitement" @selected($certificat->status === 'En cours de traitement')>En cours de
                                            traitement</option>
                                        <option value="Incomplète" @selected($certificat->status === 'Incomplète')>Incomplète</option>
                                        <option value="Délivré" @selected($certificat->status === 'Délivré')>Délivré</option>
                                        <option value="Rejété" @selected($certificat->status === 'Rejété')>Rejété</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="observation"
                                        class="block text-sm font-medium text-gray-700">Observations</label>
                                    <textarea id="observation" name="observation" rows="4"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('observation', $certificat->observation) }}</textarea>
                                    @error('observation')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-6">
                                <button type="submit"
                                    class="px-6 py-3 font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition-colors duration-200 shadow-md">
                                    Mettre à jour
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
            <div class="border-t border-gray-100 pt-6 mt-8 flex justify-end">
                <a href="{{ route('certificats.index') }}"
                    class="px-6 py-3 font-semibold text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
