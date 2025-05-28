{{-- <button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button> --}}

<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'inline-flex items-center px-5 py-3 bg-gradient-to-r from-indigo-600 to-blue-500 border-0 rounded-lg font-medium text-sm text-white uppercase tracking-wider hover:from-indigo-700 hover:to-blue-600 focus:from-indigo-700 focus:to-blue-600 active:from-indigo-800 active:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition-all duration-200 ease-out shadow-md hover:shadow-lg transform hover:-translate-y-0.5 active:translate-y-0',
    ]) }}>
    {{ $slot }}
</button>
