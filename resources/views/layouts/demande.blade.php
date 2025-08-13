<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Demande</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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

        <!-- Navigation Bar (similaire au layout principal) -->
        <nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex-shrink-0 flex items-center space-x-2">
                            <span class="text-3xl caveat-brush text-indigo-600">DomiCert</span>
                        </a>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:space-x-8">
                        <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-900 border-b-2 border-transparent hover:border-indigo-500 transition-colors duration-200">
                            Accueil
                        </a>
                        <!-- Le lien "Demandes" est actif sur cette page -->
                        <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-indigo-500">
                            Demandes
                        </a>
                        <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-900 border-b-2 border-transparent hover:border-indigo-500 transition-colors duration-200">
                            À propos
                        </a>
                        <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-900 border-b-2 border-transparent hover:border-indigo-500 transition-colors duration-200">
                            Contact
                        </a>
                    </div>
                    <div class="hidden sm:flex sm:items-center">
                        <a href="#" class="px-4 py-2 font-semibold text-sm text-indigo-600 bg-indigo-50 rounded-full hover:bg-indigo-100 transition-colors duration-200">
                            Se connecter
                        </a>
                    </div>
                    <div class="flex items-center sm:hidden">
                        <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="#" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 bg-gray-50 border-l-4 border-indigo-500">
                        Accueil
                    </a>
                    <a href="#" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 border-l-4 border-transparent hover:border-gray-300">
                        Demandes
                    </a>
                    <a href="#" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 border-l-4 border-transparent hover:border-gray-300">
                        À propos
                    </a>
                    <a href="#" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 border-l-4 border-transparent hover:border-gray-300">
                        Contact
                    </a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="px-4">
                        <a href="#" class="block text-base font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">
                            Se connecter
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content for New Request Page -->
        <main class="flex-grow max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xl border border-gray-100">
                <!-- Header -->
                <div class="pb-6 border-b border-gray-200">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Nouvelle demande de certificat
                    </h1>
                    <p class="mt-2 text-gray-500">
                        Veuillez remplir le formulaire ci-dessous pour faire une demande de certificat de domicile.
                    </p>
                </div>

                <!-- Request Form -->
                <form class="mt-8 space-y-6" action="#" method="POST" enctype="multipart/form-data">
                    <!-- Personal Information Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom_prenoms" class="block text-sm font-medium text-gray-700">Nom & Prénoms</label>
                            <input type="text" name="nom_prenoms" id="nom_prenoms" autocomplete="name" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                            <input type="date" name="date_naissance" id="date_naissance" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="lieu_naissance" class="block text-sm font-medium text-gray-700">Lieu de naissance</label>
                            <input type="text" name="lieu_naissance" id="lieu_naissance" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="telephone" class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
                            <input type="tel" name="telephone" id="telephone" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Address Information Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-200">
                        <div>
                            <label for="adresse_maison" class="block text-sm font-medium text-gray-700">Adresse de votre maison</label>
                            <input type="text" name="adresse_maison" id="adresse_maison" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="quartier" class="block text-sm font-medium text-gray-700">Quartier</label>
                            <select id="quartier" name="quartier" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Sélectionnez un quartier</option>
                                <!-- Replace with dynamic data from your backend -->
                                <option value="Quartier A">Quartier A</option>
                                <option value="Quartier B">Quartier B</option>
                                <option value="Quartier C">Quartier C</option>
                            </select>
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <div class="space-y-4 pt-6 border-t border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Documents à fournir</h2>
                        <div>
                            <label for="piece_identite" class="block text-sm font-medium text-gray-700">Copie de la pièce d'identité</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.293-3.293A4 4 0 0028.707 14H22a4 4 0 00-4 4v20M8 24h12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="piece_identite" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Téléchargez un fichier</span>
                                            <input id="piece_identite" name="piece_identite" type="file" required class="sr-only">
                                        </label>
                                        <p class="pl-1">ou glissez-déposez ici</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, PDF jusqu'à 5MB</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="justificatif_domicile" class="block text-sm font-medium text-gray-700">Justificatif de domicile (facture)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.293-3.293A4 4 0 0028.707 14H22a4 4 0 00-4 4v20M8 24h12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="justificatif_domicile" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Téléchargez un fichier</span>
                                            <input id="justificatif_domicile" name="justificatif_domicile" type="file" required class="sr-only">
                                        </label>
                                        <p class="pl-1">ou glissez-déposez ici</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, PDF jusqu'à 5MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            Envoyer la demande
                        </button>
                    </div>
                </form>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-8 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-sm text-gray-500">&copy; 2023 DomiCert. Tous droits réservés.</p>
            </div>
        </footer>
    </div>
</body>
</html>