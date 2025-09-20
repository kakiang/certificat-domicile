<x-app-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-4 sm:mb-0">Liste des paiements</h1>
        </div>

        @if ($payments->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                Aucun paiement n'a été trouvé.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($payments as $payment)
                    @php
                        $statusClass = [
                            'pending' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20',
                            'initiated' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                            'success' => 'bg-green-50 text-green-700 ring-green-600/20',
                            'failed' => 'bg-red-50 text-red-700 ring-red-600/20',
                            'cancelled' => 'bg-gray-50 text-gray-700 ring-gray-600/20',
                            'invalid' => 'bg-red-50 text-red-700 ring-red-600/20',
                        ][$payment->status] ?? 'bg-gray-50 text-gray-700 ring-gray-600/20';
                    @endphp

                    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900">
                                Commande #{{ $payment->order_id }}
                            </h3>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusClass }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-3 text-sm text-gray-700">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-dollar-sign text-green-600"></i>
                                <p><span class="font-medium">Montant:</span> {{ number_format($payment->amount, 2) }} {{ $payment->currency }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-box text-gray-500"></i>
                                <p><span class="font-medium">Article:</span> {{ $payment->item_name }}</p>
                            </div>
                            @if($payment->customer_email)
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-envelope text-gray-500"></i>
                                    <p><span class="font-medium">Client:</span> {{ $payment->customer_email }}</p>
                                </div>
                            @endif
                            @if($payment->user)
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-user text-gray-500"></i>
                                    <p><span class="font-medium">Utilisateur:</span> {{ $payment->user->name }}</p>
                                </div>
                            @endif
                            @if($payment->certificat)
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-file-invoice text-gray-500"></i>
                                    <p><span class="font-medium">Certificat #{{ $payment->certificat->id }}</span></p>
                                </div>
                            @endif
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-address-card text-gray-500"></i>
                                <p><span class="font-medium">Adresse IP:</span> {{ $payment->ip_address ?? 'N/A' }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-calendar-alt text-gray-500"></i>
                                <p><span class="font-medium">Créé le:</span> {{ $payment->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            
                            {{-- Afficher le message d'erreur s'il est une chaîne de caractères --}}
                            @if ($payment->error_message && is_string($payment->error_message))
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-exclamation-circle text-red-500"></i>
                                    <p class="font-medium text-red-700">Erreur: {{ $payment->error_message }}</p>
                                </div>
                            @endif

                            {{-- Afficher le message d'erreur si c'est un JSON (déjà décodé), avec un bouton pour la modal --}}
                            @if ($payment->error_message && is_array($payment->error_message))
                                <div class="mt-4 border-t pt-4">
                                    <button onclick="showPaytechResponseModal({{ json_encode($payment->error_message) }})"
                                            class="text-sm font-medium text-red-600 hover:text-red-900 transition-colors">
                                        Voir les détails de l'erreur <i class="fa-solid fa-code ml-1"></i>
                                    </button>
                                </div>
                            @endif

                            {{-- Afficher la réponse Paytech si elle existe et si elle est un array (déjà décodé)--}}
                            @if($payment->paytech_response && is_array($payment->paytech_response))
                                <div class="mt-4 border-t pt-4">
                                    <button onclick="showPaytechResponseModal({{ json_encode($payment->paytech_response) }})"
                                            class="text-sm font-medium text-indigo-600 hover:text-indigo-900 transition-colors">
                                        Voir la réponse Paytech <i class="fa-solid fa-code ml-1"></i>
                                    </button>
                                </div>
                            @endif
                            
                            {{-- Afficher la réponse Paytech brute si elle existe et est une chaîne de caractères --}}
                            @if($payment->paytech_response && is_string($payment->paytech_response))
                                <div class="mt-4 border-t pt-4">
                                    <p class="text-sm text-gray-500">Réponse brute: {{ $payment->paytech_response }}</p>
                                </div>
                            @endif

                            @if($payment->custom_field)
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-info-circle text-blue-500"></i>
                                    <p><span class="font-medium">Champ perso:</span> {{ $payment->custom_field }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

    <div id="paytech-response-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full sm:p-6">
                <div>
                    <div class="mt-3 text-center sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Détails de la réponse Paytech</h3>
                        <div class="mt-2">
                            <pre id="paytech-response-content" class="text-sm text-gray-600 bg-gray-100 p-4 rounded-md overflow-x-auto"></pre>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:text-sm" onclick="hidePaytechResponseModal()">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function showPaytechResponseModal(data) {
        document.getElementById('paytech-response-content').textContent = JSON.stringify(data, null, 2);
        document.getElementById('paytech-response-modal').classList.remove('hidden');
    }

    function hidePaytechResponseModal() {
        document.getElementById('paytech-response-modal').classList.add('hidden');
    }
</script>