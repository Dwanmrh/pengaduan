@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full px-4 py-2 text-start text-sm font-medium text-black bg-[#a68f3a]'
    : 'block w-full px-4 py-2 text-start text-sm text-black hover:bg-[#a68f3a] hover:text-black';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
