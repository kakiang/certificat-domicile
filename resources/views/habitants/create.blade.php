<x-app-layout>

    {{-- <x-slot name="header">
        <x-content-nav-bar>
            <x-slot:title>
                Ajouter un habitant
            </x-slot:title>
            <x-list-link href="{{ route('habitants.index') }}">
                Lister les habitants
            </x-list-link>
        </x-content-nav-bar>
    </x-slot> --}}

    <div class="max-w-4xl mx-auto py-4">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-blue-500">
                <h2 class="text-xl font-semibold text-white">Ajouter un habitant</h2>
            </div>

            <form method="POST" action="{{ route('habitants.store') }}" class="px-6 py-6">
                @csrf

                <div>
                    <x-input-label for="maison_id" :value="__('Maison')" />
                    <x-select-input name="maison_id" id="maison_id" class="block mt-1 w-full">
                        <option value="">Selectionnez</option>
                        @foreach ($maisons as $maison)
                            <option value="{{ $maison->id }}" {{ old('maison_id') == $maison->id ? 'selected' : '' }}>
                                {{ $maison->numero . ' - ' . $maison->proprietaire->full_name }}
                            </option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('maison_id')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="nom" :value="__('Nom')" />
                    <x-text-input id="nom" name="nom" type="text" class="block mt-1 w-full" :value="old('nom')"
                        autofocus autocomplete="nom" />
                    <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="prenom" :value="__('Prenoms')" />
                    <x-text-input id="prenom" name="prenom" type="text" class="block mt-1 w-full"
                        :value="old('prenom')" autofocus autocomplete="prenom" />
                    <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="telephone" :value="__('Telephone')" />
                    <x-text-input id="telephone" name="telephone" type="tel" class="block mt-1 w-full"
                        :value="old('telephone')" autofocus autocomplete="telephone" />
                    <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                    <x-text-input id="date_naissance" name="date_naissance" type="date" class="block mt-1 w-full"
                        :value="old('date_naissance')" autofocus autocomplete="date_naissance" />
                    <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="lieu_naissance" :value="__('Lieu de naissance')" />
                    <x-text-input id="lieu_naissance" name="lieu_naissance" type="text" class="block mt-1 w-full"
                        :value="old('lieu_naissance')" autofocus autocomplete="lieu_naissance" />
                    <x-input-error :messages="$errors->get('lieu_naissance')" class="mt-2" />
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('habitants.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
                        Cancel
                    </a>
                    <x-primary-button>
                        {{ __('Enregistrer') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
