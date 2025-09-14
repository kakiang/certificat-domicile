<!-- In your Blade template -->
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">

            <div class="pb-4 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900">
                    Demande de certificat
                </h1>
            </div>

            <form method="POST" action="{{ route('certificats.store') }}" enctype="multipart/form-data">
                @csrf

                @if (isset($singleHabitant))
                    <input type="hidden" name="habitant_id" value="{{ $singleHabitant->id }}">
                @else
                    <div class="pt-6 pb-2">
                        {{-- <x-input-label for="habitant_id" :value="__('Demandeur')" /> --}}
                        <x-select-input name="habitant_id" id="habitant_id">
                            <option value="" disabled selected hidden>Selectionnez le démandeur du certificat
                            </option>
                            @foreach ($habitants as $habitant)
                                <option value="{{ $habitant->id }}" data-nom="{{ $habitant->nom }}"
                                    data-prenom="{{ $habitant->prenom }}" data-telephone="{{ $habitant->telephone }}"
                                    data-date_naissance="{{ $habitant->date_naissance }}"
                                    data-lieu_naissance="{{ $habitant->lieu_naissance }}"
                                    data-maison="{{ $habitant->maison->full_name }}"
                                    data-quartier="{{ $habitant->maison->quartier->nom }}"
                                    {{ old('habitant_id') == $habitant->id ? 'selected' : '' }}>
                                    {{ $habitant->full_name }}
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('habitant_id')" />
                    </div>
                @endif

                <div class="py-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="nom" :value="__('Nom & Prénoms')" />
                        <x-text-input id="nom" name="nom"
                            value="{{ isset($singleHabitant) ? $singleHabitant->prenom . ' ' . $singleHabitant->nom : '' }}"
                            disabled class="bg-gray-100 w-full" />
                    </div>
                    <div>
                        <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                        <x-text-input id="date_naissance" name="date_naissance"
                            value="{{ isset($singleHabitant) ? \Carbon\Carbon::parse($singleHabitant->date_naissance)->format('d/m/Y') : '' }}"
                            disabled class="bg-gray-100 w-full" />
                    </div>
                    <div>
                        <x-input-label for="lieu_naissance" :value="__('Lieu de naissance')" />
                        <x-text-input id="lieu_naissance" name="lieu_naissance"
                            value="{{ isset($singleHabitant) ? $singleHabitant->lieu_naissance : '' }}" disabled
                            class="bg-gray-100 w-full" />
                    </div>
                    <div>
                        <x-input-label for="telephone" :value="__('Téléphone')" />
                        <x-text-input id="telephone" name="telephone"
                            value="{{ isset($singleHabitant) ? $singleHabitant->telephone : '' }}" disabled
                            class="bg-gray-100 w-full" />
                    </div>
                    <div>
                        <x-input-label for="maison" :value="__('Maison')" />
                        <x-text-input id="maison" name="maison"
                            value="{{ isset($singleHabitant) ? $singleHabitant->maison->full_name : '' }}" disabled
                            class="bg-gray-100 w-full" />
                    </div>
                    <div>
                        <x-input-label for="quartier" :value="__('Quartier')" />
                        <x-text-input id="quartier" name="quartier"
                            value="{{ isset($singleHabitant) ? $singleHabitant->maison->quartier->nom : '' }}" disabled
                            class="bg-gray-100 w-full" />
                    </div>
                </div>

                <div class="space-y-4 py-6">
                    <h2 class="text-lg font-semibold text-gray-900">Documents à fournir</h2>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                        <div>
                            <x-input-label for="piece_identite" :value="__('Type pièce d\'identité')" class="sr-only" />
                            <x-select-input name="piece_identite" id="piece_identite" class="w-full">
                                <option value="" disabled selected hidden class="text-gray-400">Pièce d'identité
                                </option>
                                <option value="CNI">Carte d'identité</option>
                                <option value="Passeport">Passeport</option>
                                <option value="Autre">Autre</option>
                            </x-select-input>
                        </div>
                        <div>
                            <x-input-label for="piece_identite_file_path" :value="__('Fichier pièce d\'identité')" class="sr-only" />
                            <input type="file" id="piece_identite_file_path" name="piece_identite_file_path"
                                class="block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('piece_identite_file_path')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                        <div>
                            <x-input-label for="justificatif_domicile" :value="__('Type justificatif de domicile')" class="sr-only" />
                            <x-select-input name="justificatif_domicile" id="justificatif_domicile" class="w-full">
                                <option value="" disabled selected hidden class="text-gray-400">Justificatif
                                    domicile</option>
                                <option value="FACTURE_ELECTRICITE">facture d'électricité</option>
                                <option value="FACTURE_EAU">facture d'eau</option>
                                <option value="FACTURE_TEL">facture de téléphone</option>
                                <option value="Autre">Autre</option>
                            </x-select-input>
                        </div>
                        <div>
                            <x-input-label for="justificatif_domicile_file_path" :value="__('Fichier justificatif de domicile')" class="sr-only" />
                            <input type="file" id="justificatif_domicile_file_path"
                                name="justificatif_domicile_file_path"
                                class="block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('justificatif_domicile_file_path')" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end space-x-4 pt-6">
                    <a href="{{ route('certificats.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
                        Annuler
                    </a>
                    <x-primary-button>
                        Enregistrer
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
                @if (!isset($singleHabitant))
                    // Only run the selection logic if there are multiple habitants
                    const habitantSelector = document.getElementById('habitant_id');

                    habitantSelector.addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];

                        if (selectedOption.value) {
                            // Remplir les champs avec les data-attributes
                            document.getElementById('nom').value =
                                `${selectedOption.dataset.prenom} ${selectedOption.dataset.nom}`;
                            document.getElementById('telephone').value = selectedOption.dataset.telephone;
                            document.getElementById('date_naissance').value = formatDate(selectedOption.dataset
                                .date_naissance);
                            document.getElementById('lieu_naissance').value = selectedOption.dataset
                                .lieu_naissance;
                            document.getElementById('maison').value = selectedOption.dataset.maison;
                            document.getElementById('quartier').value = selectedOption.dataset.quartier;
                        } else {
                            // Vider les champs si aucun habitant sélectionné
                            ['nom', 'telephone', 'date_naissance', 'lieu_naissance', 'maison', 'quartier']
                            .forEach(field => {
                                document.getElementById(field).value = '';
                            });
                        }
                    });
                @endif
            });
        </script>
    </x-slot>
</x-app-layout>
