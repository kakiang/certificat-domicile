<div class="px-4 sm:px-6 lg:px-8 py-12 sm:py-8">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md border border-gray-100">
        <!-- Header with Title and Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-900">
                {{ $title }}
            </h1>
            {{ $addlink }}
       
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 font-medium">
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
