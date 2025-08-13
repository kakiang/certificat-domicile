<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Certificat Domicile') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=caveat-brush:400" rel="stylesheet" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .caveat-brush {
            font-family: 'Caveat Brush', handwriting;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">
    <!-- Main container -->
    <div class="min-h-screen flex flex-col">

        <!-- Navigation Bar -->
        @include('layouts.navigation')

        @include('layouts.sessionmessage')
        <!-- Main Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-8 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-sm text-gray-500">&copy; 2025 DomiCert. Tous droits réservés.</p>
            </div>
        </footer>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sessionMessageContainer = document.getElementById('seesionmessage');
            if (sessionMessageContainer) {
                setTimeout(() => {
                    sessionMessageContainer.style.display = 'none';
                }, 10000);
            }
        });
    </script>
    @isset($scripts)
        {{ $scripts }}
    @endisset
    
</body>

</html>
