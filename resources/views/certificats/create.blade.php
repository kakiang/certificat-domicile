<x-app-layout>

    <div class="max-w-4xl mx-auto py-4">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-blue-500">
                <h2 class="text-xl font-semibold text-white">
                    Faire une demande de certificat
                </h2>
            </div>

            <form method="POST" action="{{ route('certificats.store') }}" class="px-6 py-6">
                @csrf

                <div>
                    <x-input-label for="habitant_id" :value="__('Demandeur')" />
                    <x-select-input name="habitant_id" id="habitant_id">
                        <option value="">Selectionnez</option>
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

                <div class="mt-4 flex space-x-4"">
                    <div class="flex-1">
                        <x-input-label for="nom" :value="__('Nom & Prénoms')" />
                        <x-text-input id="nom" name="nom" disabled class="bg-gray-100" />
                    </div>
                    {{-- <div class="flex-1">
                        <x-input-label for="prenom" :value="__('Prenoms')" />
                        <x-text-input id="prenom" name="prenom" disabled class="bg-gray-100" />
                    </div> --}}
                    <div class="flex-1">
                        <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                        <x-text-input id="date_naissance" name="date_naissance" disabled class="bg-gray-100" />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="lieu_naissance" :value="__('Lieu de naissance')" />
                        <x-text-input id="lieu_naissance" name="lieu_naissance" disabled class="bg-gray-100" />
                    </div>
                </div>

                <div class="mt-4 flex space-x-4">
                    <div class="flex-1">
                        <x-input-label for="telephone" :value="__('Telephone')" />
                        <x-text-input id="telephone" name="telephone" disabled class="bg-gray-100" />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="maison" :value="__('Maison')" />
                        <x-text-input id="maison" name="maison" disabled class="bg-gray-100" />
                    </div>

                    <div class="flex-1">
                        <x-input-label for="quartier" :value="__('Quartier')" />
                        <x-text-input id="quartier" name="quartier" disabled class="bg-gray-100" />
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('certificats.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
                        Annuler
                    </a>
                    <x-primary-button>
                        {{ __('Enregistrer') }}
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

                habitantSelector.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];

                    if (selectedOption.value) {
                        // Remplir les champs avec les data-attributes
                        document.getElementById('nom').value =
                            `${selectedOption.dataset.prenom} ${selectedOption.dataset.nom}`;
                        // document.getElementById('prenom').value = selectedOption.dataset.prenom;
                        document.getElementById('telephone').value = selectedOption.dataset.telephone;
                        document.getElementById('date_naissance').value = formatDate(selectedOption.dataset
                            .date_naissance);
                        document.getElementById('lieu_naissance').value = selectedOption.dataset.lieu_naissance;
                        document.getElementById('maison').value = selectedOption.dataset.maison;
                        document.getElementById('quartier').value = selectedOption.dataset.quartier;
                    } else {
                        // Vider les champs si aucun habitant sélectionné
                        ['nom', 'prenom', 'telephone', 'date_naissance', 'lieu_naissance', 'maison', 'quartier']
                        .forEach(field => {
                            document.getElementById(field).value = '';
                        });
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
