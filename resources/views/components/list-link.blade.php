<a {{ $attributes->merge(['class' => "font-medium inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white rounded-lg shadow hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5"]) }}>
    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
    {{ $slot }}
</a>
