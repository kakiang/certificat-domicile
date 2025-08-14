<x-app-layout>
    <x-table-card>
        <x-slot:title>Liste des habitants</x-slot:title>
        <x-slot:addlink>
            <x-add-link href="{{ route('habitants.create') }}">Ajouter un habitant</x-add-link>
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
                    Email
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
                    class="px-6 py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Maison
                </th>
                <th scope="col"
                    class="px-6 py-3 text-right text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </x-slot:theadcontent>
        <x-slot:tbodycontent>
            @forelse($habitants as $habitant)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-1 whitespace-nowrap">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-600 font-medium">{{ substr($habitant->nom, 0, 1) }}</span>
                            </div>
                            <div class="ml-4 font-medium">
                                {{ $habitant->full_name }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $habitant->telephone }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $habitant->user?->email }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $habitant->date_naissance->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $habitant->lieu_naissance }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap">
                        {{ $habitant->maison->numero }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-3">
                            <x-show-link href="{{ route('habitants.show', $habitant) }}" />
                            <x-edit-link href="{{ route('habitants.edit', $habitant) }}" />
                            <form action="{{ route('habitants.destroy', $habitant) }}" method="POST" class="inline">
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
        <x-slot:pagination>{{ $habitants->links() }}</x-slot:pagination>
    </x-table-card>

</x-app-layout>
