<div class="container mx-auto py-4">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Card Header with Gradient Background -->
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-blue-500">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-white">{{ $title }}</h2>
                {{ $addlink }}
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    {{ $theadcontent }}
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{ $tbodycontent }}
                </tbody>
            </table>
        </div>
        @isset($pagination)
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $pagination }}
            </div>
        @endisset
    </div>
</div>
