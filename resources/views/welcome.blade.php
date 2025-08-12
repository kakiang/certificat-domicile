<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat Domicile App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=caveat-brush:400" rel="stylesheet" />

    <style>
        .caveat-brush {
            font-family: 'Caveat Brush', handwriting;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-lg">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <a href="/" class="text-2xl font-bold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Certificat Domicile
                </a>
                <div class="hidden md:flex space-x-1">
                    @if (Route::has('login'))
                        @auth

                            <a href="{{ route('dashboard') }}"
                                class="nav-link px-4 py-2 rounded transition-all hover:bg-blue-500/20">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="nav-link px-4 py-2 rounded transition-all hover:bg-blue-500/20">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="nav-link px-4 py-2 rounded transition-all hover:bg-blue-500/20">Créer un
                                    compte</a>
                            @endif

                        @endauth
                    @endif

                </div>

            </div>
        </nav>

        <main class="flex-grow flex container mx-auto items-center justify-center lg:p-20">

            <p class="caveat-brush text-2xl">
                Un certificat de domicile est un document attestant de l'adresse
                de résidence d'une personne. Il est souvent requis pour diverses
                démarches administratives
            </p>

        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-4">
            <div class="container mx-auto px-4">
                <div class="pt-4 text-center text-gray-400 text-sm">
                    <p>&copy; {{ date('Y') }} Certificat Domicile App. Tous droits reservés.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
