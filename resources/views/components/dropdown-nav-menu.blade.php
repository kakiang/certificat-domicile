@props(['active'])

@php
    $baseClasses = "inline-flex items-center px-4 py-5 pb-5.5";
    $activeClasses = 'font-bold border-b-4 border-white';
    $inactiveClasses = "after:content-[''] after:absolute after:w-0 after:h-[4px] after:-bottom-[4px] after:left-0 after:bg-white after:transition-all after:duration-300 hover:after:w-full hover:-translate-y-0.5 hover:shadow-lg transition-transform duration-300 ease-in-out";
    $classes = $baseClasses . ' ' . ( $active ?? false ? $activeClasses : $inactiveClasses);
@endphp

<div x-data="{ open: false }" class="relative inline-block">
    <button 
        @click="open = !open"
        {{ $attributes->merge(['class' => $classes . ' focus:outline-none']) }}
    >
        {{ $slot }}
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    
    <div 
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        style="display: none;"
    >
        <div class="py-1">
            {{ $dropdown }}
        </div>
    </div>
</div>