<x-app-layout>

    <div class="max-w-4xl mx-auto py-12 sm:py-8">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-blue-500">
                <h2 class="text-xl font-semibold text-white">
                    Modifier la demande de certificat
                </h2>
            </div>

            <form method="POST" action="{{ route('certificats.update', $certificat) }}" enctype="multipart/form-data"
                class="px-6 py-6">
                @csrf
                @method('PUT') {{-- Indique que c'est une requête PUT pour la mise à jour --}}

                <div>
                    <x-input-label for="habitant_id" :value="__('Demandeur')" />
                    <x-select-input name="habitant_id" id="habitant_id">
                        <option value="" disabled>Selectionnez le démandeur du certificat</option>
                        @foreach ($habitants as $habitant)
                            <option value="{{ $habitant->id }}" data-nom="{{ $habitant->nom }}"
                                data-prenom="{{ $habitant->prenom }}" data-telephone="{{ $habitant->telephone }}"
                                data-date_naissance="{{ $habitant->date_naissance }}"
                                data-lieu_naissance="{{ $habitant->lieu_naissance }}"
                                data-maison="{{ $habitant->maison->full_name }}"
                                data-quartier="{{ $habitant->maison->quartier->nom }}"
                                {{ $certificat->habitant_id == $habitant->id || old('habitant_id') == $habitant->id ? 'selected' : '' }}>
                                {{ $habitant->full_name }}
                            </option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('habitant_id')" />
                </div>

                <!-- Grille responsive pour les détails du demandeur -->
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="nom" :value="__('Nom & Prénoms')" />
                        <x-text-input id="nom" name="nom" disabled class="bg-gray-100 w-full"
                            value="{{ $certificat->habitant->full_name ?? '' }}" />
                    </div>
                    <div>
                        <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                        <x-text-input id="date_naissance" name="date_naissance" disabled class="bg-gray-100 w-full"
                            value="{{ \Carbon\Carbon::parse($certificat->habitant->date_naissance)->format('d/m/Y') ?? '' }}" />
                    </div>
                    <div>
                        <x-input-label for="lieu_naissance" :value="__('Lieu de naissance')" />
                        <x-text-input id="lieu_naissance" name="lieu_naissance" disabled class="bg-gray-100 w-full"
                            value="{{ $certificat->habitant->lieu_naissance ?? '' }}" />
                    </div>
                    <div>
                        <x-input-label for="telephone" :value="__('Téléphone')" />
                        <x-text-input id="telephone" name="telephone" disabled class="bg-gray-100 w-full"
                            value="{{ $certificat->habitant->telephone ?? '' }}" />
                    </div>
                    <div>
                        <x-input-label for="maison" :value="__('Maison')" />
                        <x-text-input id="maison" name="maison" disabled class="bg-gray-100 w-full"
                            value="{{ $certificat->habitant->maison->full_name ?? '' }}" />
                    </div>
                    <div>
                        <x-input-label for="quartier" :value="__('Quartier')" />
                        <x-text-input id="quartier" name="quartier" disabled class="bg-gray-100 w-full"
                            value="{{ $certificat->habitant->maison->quartier->nom ?? '' }}" />
                    </div>
                </div>


                <h2
                    class="text-xl font-semibold text-gray-800 mt-8 mb-4 leading-tight">
                    Documents à fournir
                </h2>
                
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 items-center">
                    <div>
                        <x-input-label for="piece_identite" :value="__('Type pièce d\'identité')" class="sr-only" />
                        <x-select-input name="piece_identite" id="piece_identite" class="w-full">
                            <option value="" disabled class="text-gray-400">Type pièce d'identité</option>
                            <option value="CNI"
                                {{ $certificat->piece_identite == 'CNI' || old('piece_identite') == 'CNI' ? 'selected' : '' }}>
                                Carte d'identité</option>
                            <option value="Passeport"
                                {{ $certificat->piece_identite == 'Passeport' || old('piece_identite') == 'Passeport' ? 'selected' : '' }}>
                                Passeport</option>
                            <option value="Autre"
                                {{ $certificat->piece_identite == 'Autre' || old('piece_identite') == 'Autre' ? 'selected' : '' }}>
                                Autre</option>
                        </x-select-input>
                    </div>
                    @if ($certificat->piece_identite_file_path)
                        <div>
                            <p class=" mt-1">Fichier actuel:
                                <a href="{{ Storage::url($certificat->piece_identite_file_path) }}" target="_blank"
                                    class="text-indigo-600 hover:underline">{{ $certificat->piece_identite_slug }}</a>
                            </p>
                        </div>
                    @endif
                    <div>
                        <x-input-label for="piece_identite_file_path" :value="__('Fichier pièce d\'identité')" class="sr-only" />
                        <input type="file" id="piece_identite_file_path" name="piece_identite_file_path"
                            class="block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        <x-input-error :messages="$errors->get('piece_identite_file_path')" class="mt-2" />
                    </div>

                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 items-center">
                    <div>
                        <x-input-label for="justificatif_domicile" :value="__('Type justificatif de domicile')" class="sr-only" />
                        <x-select-input name="justificatif_domicile" id="justificatif_domicile" class="w-full">
                            <option value="" disabled class="text-gray-400">Justificatif domicile</option>
                            <option value="FACTURE_ELECTRICITE"
                                {{ $certificat->justificatif_domicile == 'FACTURE_ELECTRICITE' || old('justificatif_domicile') == 'FACTURE_ELECTRICITE' ? 'selected' : '' }}>
                                facture d'électricité</option>
                            <option value="FACTURE_EAU"
                                {{ $certificat->justificatif_domicile == 'FACTURE_EAU' || old('justificatif_domicile') == 'FACTURE_EAU' ? 'selected' : '' }}>
                                facture d'eau</option>
                            <option value="FACTURE_TEL"
                                {{ $certificat->justificatif_domicile == 'FACTURE_TEL' || old('justificatif_domicile') == 'FACTURE_TEL' ? 'selected' : '' }}>
                                facture de téléphone</option>
                            <option value="Autre"
                                {{ $certificat->justificatif_domicile == 'Autre' || old('justificatif_domicile') == 'Autre' ? 'selected' : '' }}>
                                Autre</option>
                        </x-select-input>
                    </div>
                    @if ($certificat->justificatif_domicile_file_path)
                        <div>
                            <p class="mt-1">Fichier actuel: <a
                                    href="{{ Storage::url($certificat->justificatif_domicile_file_path) }}"
                                    target="_blank" class="text-indigo-600 hover:underline">{{ $certificat->justificatif_domicile_slug }}</a></p>
                        </div>
                    @endif
                    <div>
                        <x-input-label for="justificatif_domicile_file_path" :value="__('Fichier justificatif de domicile')" class="sr-only" />
                        <input type="file" id="justificatif_domicile_file_path"
                            name="justificatif_domicile_file_path"
                            class="block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        <x-input-error :messages="$errors->get('justificatif_domicile_file_path')" class="mt-2" />

                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6 mt-6">
                    <a href="{{ route('certificats.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
                        Annuler
                    </a>
                    <x-primary-button>
                        {{ __('Mettre à jour') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function formatDate(dateString) {
                if (!dateString) return '';

                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();

                return `${day}/${month}/${year}`;
            }

            document.addEventListener('DOMContentLoaded', function() {
                const habitantSelector = document.getElementById('habitant_id');

                // Fonction pour mettre à jour les champs désactivés
                function updateHabitantDetails(selectedOption) {
                    if (selectedOption && selectedOption.value) {
                        document.getElementById('nom').value =
                            `${selectedOption.dataset.prenom} ${selectedOption.dataset.nom}`;
                        document.getElementById('telephone').value = selectedOption.dataset.telephone;
                        document.getElementById('date_naissance').value = formatDate(selectedOption.dataset
                            .date_naissance);
                        document.getElementById('lieu_naissance').value = selectedOption.dataset.lieu_naissance;
                        document.getElementById('maison').value = selectedOption.dataset.maison;
                        document.getElementById('quartier').value = selectedOption.dataset.quartier;
                    } else {
                        // Vider les champs si aucun habitant sélectionné ou si l'option par défaut est choisie
                        ['nom', 'telephone', 'date_naissance', 'lieu_naissance', 'maison', 'quartier']
                        .forEach(field => {
                            document.getElementById(field).value = '';
                        });
                    }
                }

                // Initialisation des champs au chargement de la page si un habitant est déjà sélectionné
                const initialSelectedOption = habitantSelector.options[habitantSelector.selectedIndex];
                updateHabitantDetails(initialSelectedOption);


                // Écouteur d'événements pour les changements de sélection
                habitantSelector.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    updateHabitantDetails(selectedOption);
                });
            });
        </script>
    </x-slot>
</x-app-layout>
