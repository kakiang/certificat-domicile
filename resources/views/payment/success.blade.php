<x-app-layout>
 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">
            <div class="pb-2 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">
                        Paiement Réussi !
                    </h1>
                    <p class="text-gray-600 mt-2">Merci pour votre achat. Votre transaction a été traitée avec succès.</p>
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
                            <p class="text-sm font-medium text-gray-500">Montant payé</p>
                            <p class="font-bold text-green-600">
                                {{ number_format($payment->amount, 0, ',', ' ') }} XOF
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="font-bold text-gray-900">{{ $payment->customer_email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date du paiement</p>
                            <p class="font-bold text-gray-900">{{ $payment->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <p class="text-gray-500">Détails de commande non disponibles</p>
                        </div>
                        @endif
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
                            <p class="font-bold text-gray-900">{{ $payment->payment_token ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Prochaines étapes</p>
                            <p class="text-sm text-gray-700">
                                Votre certificat sera prêt à être téléchargé dans quelques heures.
                            </p>
                            <a href="#" class="text-indigo-600 hover:text-indigo-800">Certificat de domicile</a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Votre transaction est sécurisée et cryptée. 
                    <a href="{{ route('privacy') }}" class="text-indigo-600 hover:text-indigo-800">Politique de confidentialité</a>
                </p>
            </div> --}}
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
