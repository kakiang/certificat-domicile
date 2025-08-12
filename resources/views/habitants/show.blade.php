<x-app-layout>
    <div class="max-w-4xl mx-auto py-4">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-blue-500 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-white">Détails de {{ $habitant->full_name }}</h2>
                @can('update', $habitant)
                    <a href="{{ route('habitants.edit', $habitant) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Modifier
                    </a>
                @endcan
            </div>

            <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8">

                <div class="mt-4">
                    <p class="font-medium text-gray-500">Nom</p>
                    <p class="text-lg text-gray-900">{{ $habitant->nom }}</p>
                </div>

                <div class="mt-4">
                    <p class="font-medium text-gray-500">Prénoms</p>
                    <p class="text-lg text-gray-900">{{ $habitant->prenom }}</p>
                </div>

                <div class="mt-4">
                    <p class="font-medium text-gray-500">Téléphone</p>
                    <p class="text-lg text-gray-900">{{ $habitant->telephone }}</p>
                </div>

                <div class="mt-4">
                    <p class="font-medium text-gray-500">Date de naissance</p>
                    <p class="text-lg text-gray-900">
                        {{ \Carbon\Carbon::parse($habitant->date_naissance)->format('d/m/Y') }}</p>
                </div>

                <div class="mt-4">
                    <p class="font-medium text-gray-500">Lieu de naissance</p>
                    <p class="text-lg text-gray-900">{{ $habitant->lieu_naissance }}</p>
                </div>

                <div class="mt-4">
                    <p class="font-medium text-gray-500">Maison</p>
                    <p class="text-lg text-gray-900">
                        @if ($habitant->maison)
                            {{ $habitant->maison->full_name }}
                        @else
                            Non attribuée
                        @endif
                    </p>
                </div>

                <div class="mt-4">
                    <p class="font-medium text-gray-500">Email</p>
                    <p class="text-lg text-gray-900">{{ $habitant->user?->email ?? '--' }}</p>
                </div>

                <div class="mt-4">
                    <p class="font-medium text-gray-500">Inscrit le</p>
                    <p class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($habitant->created_at)->format('d/m/Y') }}
                    </p>
                </div>

                <div class="mt-4">
                    <p class="font-medium text-gray-500">Dernière mise à jour</p>
                    <p class="text-lg text-gray-900">
                        {{ \Carbon\Carbon::parse($habitant->updated_at)->format('d/m/Y') }}</p>
                </div>

            </div>

            @if (Auth::user()->is_admin)
            <div class="flex items-center justify-end space-x-4 px-6 py-6 bg-gray-50 border-t border-gray-200">
                {{-- @can('delete', $habitant)
                    <form action="{{ route('habitants.destroy', $habitant) }}" method="POST"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet habitant ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200">
                            Supprimer
                        </button>
                    </form>
                @endcan --}}
                
                    <a href="{{ route('habitants.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
                        Retour à la liste
                    </a>
                
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
