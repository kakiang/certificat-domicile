<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">

            <div class="pb-6 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900">
                    Modifier les informations de {{ $habitant->full_name }}
                </h1>
            </div>

            <form method="POST" action="{{ route('habitants.update', $habitant) }}" class="mt-8 space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <div>
                        <x-input-label for="nom" :value="__('Nom')" />
                        <x-text-input id="nom" name="nom" type="text"
                            :value="old('nom', $habitant->nom)" autofocus autocomplete="nom" />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="prenom" :value="__('Prénoms')" />
                        <x-text-input id="prenom" name="prenom" type="text"
                            :value="old('prenom', $habitant->prenom)" autofocus autocomplete="prenom" />
                        <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="telephone" :value="__('Téléphone')" />
                        <x-text-input id="telephone" name="telephone" type="tel"
                            :value="old('telephone', $habitant->telephone)" autofocus autocomplete="telephone" />
                        <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                        <x-text-input id="date_naissance" name="date_naissance" type="date"
                            :value="old('date_naissance', $habitant->date_naissance ? \Carbon\Carbon::parse($habitant->date_naissance)->format('Y-m-d') : '')" autofocus autocomplete="date_naissance" />
                        <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="lieu_naissance" :value="__('Lieu de naissance')" />
                        <x-text-input id="lieu_naissance" name="lieu_naissance" type="text"
                            :value="old('lieu_naissance', $habitant->lieu_naissance)" autofocus autocomplete="lieu_naissance" />
                        <x-input-error :messages="$errors->get('lieu_naissance')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="maison_id" :value="__('Maison')" />
                        <x-select-input name="maison_id" id="maison_id">
                            <option value="">Sélectionnez</option>
                            @foreach ($maisons as $maison)
                                <option value="{{ $maison->id }}"
                                    {{ old('maison_id', $habitant->maison_id) == $maison->id ? 'selected' : '' }}>
                                    {{ $maison->full_name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('maison_id')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6 mt-6">
                    <a href="{{ route('habitants.index') }}"
                        class="px-5 py-2.5 font-medium text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-colors duration-200">
                        Annuler
                    </a>
                    <x-primary-button class="rounded-full">
                        Mettre à jour
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
