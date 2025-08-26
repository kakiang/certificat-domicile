<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">
            <div class="pb-2 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">
                        Paiement en cours de traitement
                    </h1>
                    <p class="text-gray-600 mt-2">Veuillez patienter pendant que nous confirmons votre paiement</p>
                </div>
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
            </div>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-gray-50 p-6 rounded-2xl">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">
                        Détails de la commande
                    </h2>
                    <div class="space-y-5">
                        @if(isset($payment) && $payment)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Numéro de commande</p>
                            <p class="font-bold text-gray-900">{{ $payment->order_id }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Article</p>
                            <p class="font-bold text-gray-900">{{ $payment->item_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Montant</p>
                            <p class="font-bold text-green-600">
                                {{ number_format($payment->amount, 0, ',', ' ') }} XOF
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="font-bold text-gray-900">{{ $payment->customer_email }}</p>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <p class="text-gray-500">Chargement des détails de la commande...</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                    <h2 class="text-xl font-semibold text-blue-800 mb-4">
                        <i class="fas fa-info-circle mr-2"></i>Statut du paiement
                    </h2>
                    <div class="space-y-5">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse mr-3"></div>
                            <div>
                                <p class="font-bold text-blue-700">En cours de vérification</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Temps estimé</p>
                            <p class="font-bold text-gray-900">Quelques secondes</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Que se passe-t-il ?</p>
                            <p class="text-sm text-gray-700">
                                Nous confirmons votre paiement avec notre processeur de paiement. 
                                Cette page se mettra à jour automatiquement.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-yellow-50 p-6 rounded-2xl border border-yellow-200">
                <h2 class="text-xl font-semibold text-yellow-800 mb-4">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Ne quittez pas cette page
                </h2>
                <p class="text-yellow-700">
                    La fermeture de cette page pourrait interrompre le processus de confirmation. 
                    Si la page ne se met pas à jour automatiquement, cliquez sur le bouton ci-dessous.
                </p>
                
                <div class="mt-4 flex flex-col sm:flex-row gap-4">
                    <button onclick="window.location.reload()" 
                            class="px-6 py-3 font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition-all duration-200 ease-in-out shadow-md hover:shadow-lg">
                        <i class="fas fa-sync mr-2"></i>Actualiser la page
                    </button>
                    
                    {{-- <a href="#" 
                       class="px-6 py-3 font-semibold text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 transition-all duration-200 ease-in-out">
                        <i class="fas fa-shopping-cart mr-2"></i>Retour au paiement
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">

        <script>
            // Auto-refresh la page toutes les 10 secondes pour vérifier le statut du paiement
            setTimeout(function() {
                window.location.reload();
            }, 10000);
        </script>
    </x-slot>
</x-app-layout>
