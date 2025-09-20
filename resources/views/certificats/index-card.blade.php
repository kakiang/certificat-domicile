<x-app-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-4 sm:mb-0">Liste des demandes de certificats</h1>
    <x-add-link href="{{ route('certificats.create') }}">Faire une demande</x-add-link>
</div>

        @if ($certificats->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                Aucune demande ou certificat n'a été trouvé.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($certificats as $certificat)
                    @php
                        $statusClass = [
                            'En attente' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20',
                            'En cours de traitement' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                            'Incomplète' => 'bg-gray-50 text-gray-700 ring-gray-600/20',
                            'Délivré' => 'bg-green-50 text-green-700 ring-green-600/20',
                            'Rejété' => 'bg-red-50 text-red-700 ring-red-600/20',
                        ][$certificat->status] ?? 'bg-gray-50 text-gray-700 ring-gray-600/20';
                    @endphp

                    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-900">
                                {{ $certificat->habitant->full_name }}
                            </h3>
                            <span class="inline-flex items-center rounded-full px-3 py-1 font-semibold ring-1 ring-inset {{ $statusClass }}">
                                {{ $certificat->status }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-2 text-sm text-gray-700">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-house text-gray-500"></i>
                                <p><span class="font-medium">Maison:</span> {{ $certificat->habitant->maison->full_name }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-hashtag text-gray-500"></i>
                                <p><span class="font-medium">Numéro de certificat:</span> {{ $certificat->numero_certificat ?? 'N/A' }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-calendar-alt text-gray-500"></i>
                                <p><span class="font-medium">Date de demande:</span> {{ $certificat->date_demande->format('d/m/Y H:i') }}</p>
                            </div>
                            @if($certificat->date_delivrance)
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-check-circle text-gray-500"></i>
                                    <p><span class="font-medium">Date de délivrance:</span> {{ $certificat->date_delivrance->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 flex justify-end space-x-4 border-t pt-4">
                            @if ($certificat->status === 'Délivré')
                                <a href="{{ route('certificats.print', $certificat) }}" target="_blank" title="Imprimer le certificat">
                                    <i class="fa-solid fa-print text-xl text-indigo-600 hover:text-indigo-800 transition-colors"></i>
                                </a>
                            @endif
                            @can('view', $certificat)
                                <a href="{{ route('certificats.show', $certificat) }}" title="Voir les détails">
                                    <i class="fa-solid fa-eye text-xl text-gray-600 hover:text-gray-800 transition-colors"></i>
                                </a>
                            @endcan
                            @if ($certificat->status !== 'Délivré' || Auth::user()->is_admin)
                                @can('update', $certificat)
                                    <a href="{{ route('certificats.edit', $certificat) }}" title="Modifier la demande">
                                        <i class="fa-solid fa-edit text-xl text-yellow-600 hover:text-yellow-800 transition-colors"></i>
                                    </a>
                                @endcan
                                @can('delete', $certificat)
                                    <form action="{{ route('certificats.destroy', $certificat) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Supprimer la demande">
                                            <i class="fa-solid fa-trash-alt text-xl text-red-600 hover:text-red-800 transition-colors"></i>
                                        </button>
                                    </form>
                                @endcan
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $certificats->links() }}
            </div>
        @endif
    </div>
</x-app-layout>