@props(['active' => false, 'icon', 'type', 'iconSize' => 10])

@php
    // TODO: Fix active indicator
    $activeClass = $active ? 'bg-gray-500' : '';
    $classes = "flex items-center gap-4 font-medium text-white rounded-full p-2 hover:bg-gray-500 before:block before:absolute before:p-8 before:text-center before:-z-10 hover:cursor-pointer $activeClass";
@endphp

@if ($type ?? false === 'submit')
    <button {{ $attributes->merge(['class' => "$classes"]) }}>
        @svg($icon, ['class' => "size-$iconSize"])
        <span class="hidden lg:block">{{ $slot }}</span>
    </button>
@else
    <a {{ $attributes->merge(['class' => "$classes"]) }}>
        @svg($icon, ['class' => "size-$iconSize"])
        <span class="hidden lg:block">{{ $slot }}</span>
    </a>
@endif
