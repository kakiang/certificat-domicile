<x-app-layout>
    <x-table-card>
        <x-slot:title>Liste des propriétaires</x-slot:title>
        <x-slot:addlink>
            <x-add-link href="{{ route('proprietaires.create') }}">Ajouter un propriétaire</x-add-link>
        </x-slot:addlink>
        <x-slot:theadcontent>
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Nom & Prenoms
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Telephone
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    DATE DE NAISSANCE
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Lieu de naissance
                </th>
                <th scope="col"
                    class="px-6 py-3 text-right text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </x-slot:theadcontent>
        <x-slot:tbodycontent>
            @forelse($proprietaires as $proprietaire)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-1 whitespace-nowrap">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-600 font-medium">{{ substr($proprietaire->nom, 0, 1) }}</span>
                            </div>
                            <div class="ml-4 font-medium">
                                {{ $proprietaire->full_name }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $proprietaire->telephone }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $proprietaire->date_naissance->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $proprietaire->lieu_naissance }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-3">
                            <x-show-link href="{{ route('proprietaires.show', $proprietaire) }}" />
                            <x-edit-link href="{{ route('proprietaires.edit', $proprietaire) }}" />
                            <form action="{{ route('proprietaires.destroy', $proprietaire) }}" method="POST" class="inline">
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
        <x-slot:pagination>{{ $proprietaires->links() }}</x-slot:pagination>
    </x-table-card>
</x-app-layout>
