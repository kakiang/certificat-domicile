{{-- <a {{ $attributes->merge(['class' => "bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full flex items-center justify-center w-8 h-8", 'title'=>"Show"]) }}>
    <i class="fas fa-eye text-xs"></i>
</a> --}}

<a {{ $attributes->merge(['class' => 'text-blue-500 hover:text-blue-700', 'title' => 'Show']) }}>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </svg>
</a>