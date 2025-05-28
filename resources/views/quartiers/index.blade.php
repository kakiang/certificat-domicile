<x-app-layout>
    <x-slot name="header">
        <x-content-nav-bar>
            <x-slot:title>
                Liste des quartiers
            </x-slot:title>
            <x-add-link href="{{ route('quartiers.create') }}">
                Ajouter un quartier
            </x-add-link>
        </x-content-nav-bar>
    </x-slot>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-3 py-2 text-left">#</th>
                    <th class="px-3 py-2 text-left">NOM</th>
                    <th class="px-3 py-2 text-left">DESCRIPTION</th>
                    <th class="px-3 py-2 text-left">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quartiers as $quartier)
                    <tr class="border-b border-gray-200 odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                        <td class="px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2">{{ $quartier->nom }}</td>
                        <td class="px-3 py-2">{{ $quartier->description }}</td>
                        <td class="px-3 py-2 text-center">
                            <div class="flex space-x-2">
                                <x-show-link href="{{ route('quartiers.show', $quartier) }}"/>
                                <x-edit-link href="{{ route('quartiers.edit', $quartier) }}"/>

                                <form action="{{ route('quartiers.destroy', $quartier) }}" method="POST"
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
            {{ $quartiers->links() }}
        </div>
    </div>
</x-app-layout>
