@props(['active', 'icon', 'type'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center gap-4 font-medium text-white my-2 py-2 px-6 rounded-full bg-gray-500 hover:bg-gray-500 hover:cursor-pointer'
            : 'flex items-center gap-4 font-medium text-white my-2 py-2 px-6 rounded-full hover:bg-gray-500 hover:cursor-pointer';
@endphp

@if ($type ?? false === 'submit')
    <button {{ $attributes->merge(['class' => $classes]) }}>
        @svg($icon, ['class' => 'size-10'])
        {{ $slot }}
    </button>
@else
    <a {{ $attributes->merge(['class' => $classes]) }}>
        @svg($icon, ['class' => 'size-10'])
        {{ $slot }}
    </a>
@endif
