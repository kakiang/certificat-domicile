<x-app-layout>

    <x-table-card>
        <x-slot:title>Liste des demandes de certificats</x-slot:title>
        <x-slot:addlink>
            <x-add-link href="{{ route('certificats.create') }}">Faire une demande de certificat</x-add-link>
        </x-slot:addlink>
        <x-slot:theadcontent>
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Nom & contact du beneficiaire
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Maison
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Date demande
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Statut
                </th>
                <th scope="col"
                    class="px-6 py-3 text-right text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </x-slot:theadcontent>
        <x-slot:tbodycontent>
            @forelse($certificats as $certificat)
                @php
                    $statusClass =
                        [
                            'En attente' => 'bg-yellow-100 text-yellow-800',
                            'En cours de traitement' => 'bg-blue-100 text-blue-800',
                            'Incomplète' => 'bg-red-100 text-red-800',
                            'Délivré' => 'bg-green-100 text-green-800',
                            'Rejété' => 'bg-red-100 text-red-500',
                        ][$certificat->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-1 whitespace-nowrap">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span
                                    class="text-indigo-600 font-medium">{{ substr($certificat->habitant->nom, 0, 1) }}</span>
                            </div>
                            <div class="ml-4 flex gap-4">
                                <div class="font-medium">
                                    {{ $certificat->habitant->full_name }}
                                </div>
                                <div class="text-gray-500">
                                    {{ $certificat->habitant->telephone }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $certificat->habitant->maison->full_name }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $certificat->date_demande->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap ">
                        <span class="inline-flex items-center px-2 py-2 font-bold rounded-full {{ $statusClass }}">
                            {{ $certificat->status }}
                        </span>
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-6">
                            @if ($certificat->status === 'Délivré')
                                <a href="#">
                                    <i
                                        class="fa-solid fa-file-circle-plus text-2xl text-indigo-600 cursor-pointer hover:text-indigo-800 transition-colors duration-200"></i>
                                </a>
                            @endif
                            @if ($certificat->status !== 'Délivré' || Auth::user()->is_admin)
                                @can('view', $certificat)
                                    <x-show-link href="{{ route('certificats.show', $certificat) }}" />
                                @endcan
                                @can('update', $certificat)
                                    <x-edit-link href="{{ route('certificats.edit', $certificat) }}" />
                                @endcan
                                @can('delete', $certificat)
                                    <form action="{{ route('certificats.destroy', $certificat) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-icon-btn></x-delete-icon-btn>
                                    </form>
                                @endcan
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                        Aucun enregistrement
                    </td>
                </tr>
            @endforelse
        </x-slot:tbodycontent>
        <x-slot:pagination>{{ $certificats->links() }}</x-slot:pagination>
    </x-table-card>

</x-app-layout>
