@props(['active' => false, 'icon', 'active_icon' => null])

@php
    $currentIcon = $active && $active_icon ? $active_icon : $icon;
@endphp

<a
    {{ $attributes->merge(['class' => 'flex items-center gap-4 font-medium text-white rounded-full p-2 hover:bg-gray-800 hover:cursor-pointer']) }}>
    @svg($currentIcon, ['class' => 'size-8'])
    <span @class(['hidden lg:block', 'font-bold' => $active])>{{ $slot }}</span>
</a>
