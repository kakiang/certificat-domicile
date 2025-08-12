{{-- <a {{ $attributes->merge(['class' => "action-btn bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-full flex items-center justify-center w-8 h-8", 'title'=>"Edit"]) }}>
    <i class="fas fa-edit text-xs"></i>
</a> --}}

<a {{ $attributes->merge(['class' => 'text-indigo-500 hover:text-indigo-700', 'title' => 'Edit']) }}>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
    </svg>
</a>

{{-- <a href="{{ route('habitants.edit', $habitant) }}" class="text-indigo-500 hover:text-indigo-700" title="Edit">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
    </svg>
</a> --}}
