<x-app-layout>
    <x-table-card>
        <x-slot:title>Liste des quartiers</x-slot:title>
        <x-slot:addlink>
            <x-add-link href="{{ route('quartiers.create') }}">Ajouter un quartier</x-add-link>
        </x-slot:addlink>
        <x-slot:theadcontent>
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left md:text-sm font-bold uppercase tracking-wider rounded-tl-lg">
                    #
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left md:text-sm font-bold uppercase tracking-wider rounded-tl-lg">
                    Nom du quartier
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left md:text-sm font-bold uppercase tracking-wider">
                    Description
                </th>
                <th scope="col"
                    class="px-6 py-3 text-right md:text-sm font-bold uppercase tracking-wider rounded-tr-lg">
                    Actions
                </th>
            </tr>

        </x-slot:theadcontent>
        <x-slot:tbodycontent>
            @forelse($quartiers as $quartier)
                <tr>

                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $quartier->nom }}
                    </td>
                    <td 
                        title="{{ $quartier->description }}" 
                        class="px-6 py-2 truncate max-w-xs md:max-w-md lg:max-w-lg whitespace-normal break-words">
                         {{ Str::limit($quartier->description, 255) }}
                    </td>
                    <td class="px-6 py-2 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-4">
                            <x-show-link href="{{ route('quartiers.show', $quartier) }}" />
                            <x-edit-link href="{{ route('quartiers.edit', $quartier) }}" />
                            <form action="{{ route('quartiers.destroy', $quartier) }}" method="POST" class="inline">
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
        <x-slot:pagination>{{ $quartiers->links() }}</x-slot:pagination>
    </x-table-card>

</x-app-layout>
