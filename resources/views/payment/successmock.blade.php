<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">
            <div class="pb-2 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">
                        Paiement Réussi !
                    </h1>
                    <p class="text-gray-600 mt-2">Merci pour votre achat. Votre transaction a été traitée avec succès.
                    </p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-3xl text-green-600"></i>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-gray-50 p-6 rounded-2xl">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">
                        Résumé de la commande
                    </h2>
                    <div class="space-y-5">
                        {{-- @if (isset($payment) && $payment) --}}
                        <div>
                            <p class="text-sm font-medium text-gray-500">Numéro de commande</p>
                            <p class="font-bold text-gray-900">ORD_863</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Article</p>
                            <p class="font-bold text-gray-900">Certificat de domicile</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Montant payé</p>
                            <p class="font-bold text-green-600">
                                1500 XOF
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="font-bold text-gray-900">customer@gmail.com</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date du paiement</p>
                            <p class="font-bold text-gray-900">25/Aout/2025 22:09</p>
                        </div>
                        {{-- @else
                        <div class="text-center py-4">
                            <p class="text-gray-500">Détails de commande non disponibles</p>
                        </div>
                        @endif --}}
                    </div>
                </div>

                <div class="bg-green-50 p-6 rounded-2xl border border-green-200">
                    <h2 class="text-xl font-semibold text-green-800 mb-4">
                        <i class="fas fa-check-circle mr-2"></i>Confirmation
                    </h2>
                    <div class="space-y-5">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Statut du paiement</p>
                                <p class="font-bold text-green-700">Confirmé et réussi</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Référence de transaction</p>
                            <p class="font-bold text-gray-900">phjniunkmo589j</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Prochaines étapes</p>
                            <p class="text-sm text-gray-700">
                                Un email de confirmation a été envoyé à votre adresse.
                                Vous recevrez vos articles sous peu.
                            </p>
                            <a href="#" class="text-indigo-600 hover:text-indigo-800">Certificat de domicile</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="mt-8 bg-blue-50 p-6 rounded-2xl border border-blue-200">
                <h2 class="text-xl font-semibold text-blue-800 mb-4">
                    <i class="fas fa-rocket mr-2"></i>Que faire maintenant ?
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="text-center p-4 bg-white rounded-xl border border-gray-200">
                        <i class="fas fa-home text-2xl text-indigo-600 mb-3"></i>
                        <p class="text-sm font-medium text-gray-700">Retour à l'accueil</p>
                    </div>
                    <div class="text-center p-4 bg-white rounded-xl border border-gray-200">
                        <i class="fas fa-list text-2xl text-blue-600 mb-3"></i>
                        <p class="text-sm font-medium text-gray-700">Voir vos commandes</p>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ url('/') }}"
                        class="px-6 py-3 font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition-all duration-200 ease-in-out shadow-md hover:shadow-lg">
                        <i class="fas fa-home mr-2"></i>Retour à l'accueil
                    </a>

                    

                    <a href="#"
                        class="px-6 py-3 font-semibold text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 transition-all duration-200 ease-in-out">
                        <i class="fas fa-list mr-2"></i>Mes commandes
                    </a>
                </div>
            </div> --}}

            {{-- <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Votre transaction est sécurisée et cryptée.
                    <a href="#" class="text-indigo-600 hover:text-indigo-800">Politique de confidentialité</a>
                </p>
            </div> --}}
        </div>
    </div>

    {{-- </div> --}}
    <x-slot name="scripts">
        <script>
            // Auto-scroll to top when page loads
            document.addEventListener('DOMContentLoaded', function() {
                window.scrollTo(0, 0);

                // Add some celebratory confetti effect (optional)
                setTimeout(function() {
                    if (typeof confetti === 'function') {
                        confetti({
                            particleCount: 100,
                            spread: 70,
                            origin: {
                                y: 0.6
                            }
                        });
                    }
                }, 500);
            });

            // Optional: Add confetti library for celebration effect
            if (!document.querySelector('script[src*="confetti"]')) {
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js';
                document.head.appendChild(script);
            }
        </script>
    </x-slot>
</x-app-layout>
