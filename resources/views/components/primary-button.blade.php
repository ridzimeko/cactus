@props(['rounded' => false])

@php
    $classes = $rounded
        ? 'bg-green-800 px-4 py-2 rounded-full text-white'
        : 'bg-green-800 px-4 py-2 rounded-md text-white';
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
