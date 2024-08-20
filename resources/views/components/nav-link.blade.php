@props(['active' => false, 'icon', 'active_icon' => null, 'type'])

@php
    $classes =
        'flex items-center gap-4 font-medium text-white rounded-full p-2 hover:bg-gray-800 before:block before:absolute before:p-8 before:text-center before:-z-10 hover:cursor-pointer';
    $currentIcon = $active && $active_icon ? $active_icon : $icon;
@endphp

@if ($type ?? false === 'submit')
    <button {{ $attributes->merge(['class' => "$classes"]) }}>
        @svg($currentIcon, ['class' => 'size-10'])
        <span class="{{ $active ? 'font-bold' : '' }} hidden lg:block">{{ $slot }}</span>
    </button>
@else
    <a {{ $attributes->merge(['class' => "$classes"]) }}>
        @svg($currentIcon, ['class' => 'size-10'])
        <span class="{{ $active ? 'font-bold' : '' }} font- hidden lg:block">{{ $slot }}</span>
    </a>
@endif
