<x-app-layout>
     <x-table-card>
        <x-slot:title>Liste des maisons</x-slot:title>
        <x-slot:addlink>
            <x-add-link href="{{ route('maisons.create') }}">Ajouter une maison</x-add-link>
        </x-slot:addlink>
        <x-slot:theadcontent>
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left md:text-sm font-bold uppercase tracking-wider">
                    Numero
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left md:text-sm font-bold uppercase tracking-wider">
                    Adresse
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left md:text-sm font-bold uppercase tracking-wider">
                    Propriétaire
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left md:text-sm font-bold uppercase tracking-wider">
                    Description
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left md:text-sm font-bold uppercase tracking-wider">
                    Quartier
                </th>
                <th scope="col"
                    class="px-6 py-3 text-right md:text-sm font-bold uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </x-slot:theadcontent>
        <x-slot:tbodycontent>
            @forelse($maisons as $maison)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $maison->numero }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $maison->adresse }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $maison->proprietaire->full_name }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap max-w-xs truncate" title="{{ $maison->description }}">
                        {{ Str::limit($maison->description, 120) }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $maison->quartier->nom }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-3">
                            <x-show-link href="{{ route('maisons.show', $maison) }}" />
                            <x-edit-link href="{{ route('maisons.edit', $maison) }}" />
                            <form action="{{ route('maisons.destroy', $maison) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-delete-icon-btn></x-delete-icon-btn>
                            </form>
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
        <x-slot:pagination>{{ $maisons->links() }}</x-slot:pagination>
    </x-table-card>

</x-app-layout>
