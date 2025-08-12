@props(['active'])

@php
    $baseClasses = "inline-flex items-center px-4 py-5 pb-5.5";
    $activeClasses = 'font-medium border-b-4 border-indigo-500';
    $inactiveClasses = "after:content-[''] after:absolute after:w-0 after:h-[4px] after:-bottom-[4px] after:left-0 after:bg-indigo-500 after:transition-all after:duration-300 hover:after:w-full hover:-translate-y-0.5 hover:shadow-lg transition-transform duration-300 ease-in-out";
    $classes = $baseClasses . ' ' . ( $active ?? false ? $activeClasses : $inactiveClasses);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
