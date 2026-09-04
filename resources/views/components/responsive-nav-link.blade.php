@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full ps-4 pe-4 py-2.5 border-s-4 border-brand-600 text-start text-base font-medium text-brand-800 bg-brand-50 transition duration-150 ease-in-out'
    : 'block w-full ps-4 pe-4 py-2.5 border-s-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
