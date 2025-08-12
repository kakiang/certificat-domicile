@props(['disabled' => false])

<select @disabled($disabled)
    {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200']) }}>
    {{ $slot }}
</select>
