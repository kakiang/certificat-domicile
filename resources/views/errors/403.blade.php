<x-app-layout>
    <div class="relative overflow-hidden py-24 bg-gradient-to-br from-indigo-500 to-blue-600 sm:py-32 rounded-b-3xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-6xl sm:text-7xl lg:text-8xl font-bold tracking-tight text-white leading-tight">
                403
            </h1>
            {{-- A clear, simple message --}}
            <p class="mt-4 text-xl sm:text-2xl text-indigo-100 max-w-2xl mx-auto">
                Accès refusé. Vous n'êtes pas autorisé à voir cette page.
            </p>
            <div class="mt-10">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full shadow-lg text-indigo-600 bg-white hover:bg-gray-100 transition-colors duration-200">
                    Retourner à la page d'accueil
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
