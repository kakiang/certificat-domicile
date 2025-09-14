<x-app-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-4 sm:mb-0">Liste des habitants</h1>
            <x-add-link href="{{ route('habitants.create') }}">Ajouter un habitant</x-add-link>
        </div>

        @if ($habitants->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                Aucun habitant n'a été trouvé.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($habitants as $habitant)
                    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-xl font-bold text-indigo-600">{{ substr($habitant->nom, 0, 1) }}</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $habitant->full_name }}</h3>
                                <p class="text-sm text-gray-500">{{ $habitant->maison->full_name }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-2 text-sm text-gray-700">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-phone text-gray-500"></i>
                                <p><span class="font-medium">Téléphone:</span> {{ $habitant->telephone }}</p>
                            </div>
                            @if($habitant->user?->email)
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-envelope text-gray-500"></i>
                                <p><span class="font-medium">Email:</span> {{ $habitant->user->email }}</p>
                            </div>
                            @endif
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-calendar-alt text-gray-500"></i>
                                <p><span class="font-medium">Date de naissance:</span> {{ $habitant->date_naissance->format('d/m/Y') }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-map-marker-alt text-gray-500"></i>
                                <p><span class="font-medium">Lieu de naissance:</span> {{ $habitant->lieu_naissance }}</p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-4 border-t pt-4">
                            <a href="{{ route('habitants.show', $habitant) }}" title="Voir les détails">
                                <i class="fa-solid fa-eye text-xl text-gray-600 hover:text-gray-800 transition-colors"></i>
                            </a>
                            <a href="{{ route('habitants.edit', $habitant) }}" title="Modifier l'habitant">
                                <i class="fa-solid fa-edit text-xl text-yellow-600 hover:text-yellow-800 transition-colors"></i>
                            </a>
                            <form action="{{ route('habitants.destroy', $habitant) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet habitant ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Supprimer l'habitant">
                                    <i class="fa-solid fa-trash-alt text-xl text-red-600 hover:text-red-800 transition-colors"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $habitants->links() }}
            </div>
        @endif
    </div>
</x-app-layout>