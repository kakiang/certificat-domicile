<x-app-layout>

    <div class="max-w-4xl mx-auto py-4">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-blue-500">
                <h2 class="text-xl font-semibold text-white">S'inscrire en tant que habitant</h2>
            </div>

            <form method="POST" action="{{ route('habitants.store') }}" class="px-6 py-6">
                @csrf

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                    <div>
                        <x-input-label for="nom" :value="__('Nom')" />
                        <x-text-input id="nom" name="nom" type="text" :value="old('nom')" autofocus
                            autocomplete="nom" />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="prenom" :value="__('Prénoms')" />
                        <x-text-input id="prenom" name="prenom" type="text" :value="old('prenom')" autofocus
                            autocomplete="prenom" />
                        <x-input-error :messages="$errors->get('prenom')" />
                    </div>

                    <div>
                        <x-input-label for="telephone" :value="__('Téléphone')" />
                        <x-text-input id="telephone" name="telephone" type="tel" :value="old('telephone')" autofocus
                            autocomplete="telephone" />
                        <x-input-error :messages="$errors->get('telephone')" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                        <x-text-input id="date_naissance" name="date_naissance" type="date" :value="old('date_naissance')"
                            autofocus autocomplete="date_naissance" />
                        <x-input-error :messages="$errors->get('date_naissance')" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="lieu_naissance" :value="__('Lieu de naissance')" />
                        <x-text-input id="lieu_naissance" name="lieu_naissance" type="text" :value="old('lieu_naissance')"
                            autofocus autocomplete="lieu_naissance" />
                        <x-input-error :messages="$errors->get('lieu_naissance')" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="maison_id" :value="__('Maison')" />
                        <x-select-input name="maison_id" id="maison_id">
                            <option value="">Selectionnez</option>
                            @foreach ($maisons as $maison)
                                <option value="{{ $maison->id }}"
                                    {{ old('maison_id') == $maison->id ? 'selected' : '' }}>
                                    {{ $maison->numero . ' - ' . $maison->proprietaire->full_name }}
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('maison_id')" />
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 mt-8">
                    <a href="{{ route('habitants.index') }}"
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
</x-app-layout>
