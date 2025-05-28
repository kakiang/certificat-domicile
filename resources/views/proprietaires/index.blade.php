<x-app-layout>
    <x-slot name="header">
        <x-content-nav-bar>
            <x-slot:title>
                Liste des propriétaires
            </x-slot:title>
            <x-add-link href="{{ route('proprietaires.create') }}">
                Ajouter un Propriétaire
            </x-add-link>
        </x-content-nav-bar>
    </x-slot>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-3 py-2 text-left">#</th>
                    <th class="px-3 py-2 text-left">NOM</th>
                    <th class="px-3 py-2 text-left">PRENOM</th>
                    <th class="px-3 py-2 text-left">TELEPHONE</th>
                    <th class="px-3 py-2 text-left">DATE DE NAISSANCE</th>
                    <th class="px-3 py-2 text-left">LIEU DE NAISSANCE</th>
                    <th class="px-3 py-2 text-left">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proprietaires as $proprio)
                    <tr class="border-b border-gray-200 odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                        <td class="px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2">{{ $proprio->nom }}</td>
                        <td class="px-3 py-2">{{ $proprio->prenom }}</td>
                        <td class="px-3 py-2">{{ $proprio->telephone }}</td>
                        <td class="px-3 py-2">{{ $proprio->date_naissance->format('d/m/Y') }}</td>
                        <td class="px-3 py-2">{{ $proprio->lieu_naissance }}</td>
                        <td class="px-3 py-2 text-center">
                            <div class="flex space-x-2">
                                <x-show-link href="{{ route('proprietaires.show', $proprio) }}"/>
                                <x-edit-link href="{{ route('proprietaires.edit', $proprio) }}"/>

                                <form action="{{ route('proprietaires.destroy', $proprio) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this item?')"
                                        class="action-btn bg-red-500 hover:bg-red-600 text-white p-2 rounded-full flex items-center justify-center w-8 h-8"
                                        title="Delete">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-2 py-2">
            {{ $proprietaires->links() }}
        </div>

    </div>

</x-app-layout>
