@if (session('success') || session('error'))
    <div id="seesionmessage" class="w-full px-4 sm:px-6 lg:px-8 mt-6 space-y-3">
        @if (session('success'))
            <div class="relative px-4 py-3 bg-green-50 text-green-700 rounded-lg shadow-md border border-green-200"
                role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-circle-check text-green-500"></i>
                    </div>
                    <div class="ml-3 font-medium">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="relative px-4 py-3 bg-red-50 text-red-700 rounded-lg shadow-md border border-red-200"
                role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                    </div>
                    <div class="ml-3 font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endif
