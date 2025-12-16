@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'group inline-flex items-center px-3 py-2 border-b-2 border-indigo-500 text-sm font-semibold leading-5 text-indigo-600 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'group inline-flex items-center px-3 py-2 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-indigo-300 focus:outline-none focus:text-indigo-600 focus:border-indigo-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
