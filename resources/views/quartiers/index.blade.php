<x-app-layout>
      <x-table-card>
        <x-slot:title>Liste des quartiers</x-slot:title>
        <x-slot:addlink>
            <x-add-link href="{{ route('quartiers.create') }}">Ajouter une quartier</x-add-link>
        </x-slot:addlink>
        <x-slot:theadcontent>
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Nom du quartier
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Description
                </th>
                <th scope="col"
                    class="px-6 py-3 text-right text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </x-slot:theadcontent>
        <x-slot:tbodycontent>
            @forelse($quartiers as $quartier)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-1 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex gap-4">
                                <div class="text-gray-500">
                                    {{ $loop->iteration }}
                                </div>
                                <di>
                                    {{ $quartier->nom }}
                                </di>
                            </div>
                        </div>
                        
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $quartier->description }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-3">
                            <x-show-link href="{{ route('quartiers.show', $quartier) }}" />
                            <x-edit-link href="{{ route('quartiers.edit', $quartier) }}" />
                            <form action="{{ route('quartiers.destroy', $quartier) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" title="Delete"
                                    onclick="return confirm('Are you sure?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
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
