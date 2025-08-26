<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">
            
            <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Paramètres de l'application</h1>

            <form action="{{ route('parametres.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    
                    <div>
                        <x-input-label for="nom_commune" :value="__('Nom de la commune')" />
                        <x-text-input id="nom_commune" name="nom_commune" type="text"
                                    :value="old('nom_commune', $parametres->nom_commune ?? '')"
                                    class="mt-1 block w-full" autofocus autocomplete="nom_commune" />
                        <x-input-error :messages="$errors->get('nom_commune')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nom_departement" :value="__('Nom du département')" />
                        <x-text-input id="nom_departement" name="nom_departement" type="text"
                                    :value="old('nom_departement', $parametres->nom_departement ?? '')"
                                    class="mt-1 block w-full" autocomplete="nom_departement" />
                        <x-input-error :messages="$errors->get('nom_departement')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nom_region" :value="__('Nom de la région')" />
                        <x-text-input id="nom_region" name="nom_region" type="text"
                                    :value="old('nom_region', $parametres->nom_region ?? '')"
                                    class="mt-1 block w-full" autocomplete="nom_region" />
                        <x-input-error :messages="$errors->get('nom_region')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nom_maire" :value="__('Nom du maire')" />
                        <x-text-input id="nom_maire" name="nom_maire" type="text"
                                    :value="old('nom_maire', $parametres->nom_maire ?? '')"
                                    class="mt-1 block w-full" autocomplete="nom_maire" />
                        <x-input-error :messages="$errors->get('nom_maire')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="prix_certificat" :value="__('Prix du certificat')" />
                        <x-text-input id="prix_certificat" name="prix_certificat" type="number"
                                    :value="old('prix_certificat', $parametres->prix_certificat ?? '')"
                                    class="mt-1 block w-full" autocomplete="prix_certificat" />
                        <x-input-error :messages="$errors->get('prix_certificat')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="py-2 px-6 rounded-xl font-semibold text-white bg-green-500 hover:bg-green-600 transition duration-300 shadow-md">
                        Enregistrer les paramètres
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
