<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Certificat Domi') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Scripts -->

    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
     <link href="https://fonts.bunny.net/css?family=caveat-brush:400" rel="stylesheet" />

    <style>
        .caveat-brush {
            font-family: 'Caveat Brush', handwriting;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @isset($header)
                <header>
                    <div class="my-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            @include('layouts.session-message')

            <main>
                {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> --}}
                <div>
                    {{ $slot }}
                </div>
            </main>
        </div>

    </div>
    @isset($scripts)
    {{ $scripts }}
    @endisset
</body>

</html>
