<a
    {{ $attributes->merge(['class' => 'mt-4 sm:mt-0 inline-flex items-center px-6 py-3 border border-transparent font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200', 'title' => 'Edit']) }}">
    <i class="fa-solid fa-plus-circle mr-2"></i>
    {{ $slot }}
</a>

