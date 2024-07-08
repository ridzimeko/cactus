@props(['avatar' => null, 'size' => 'medium'])

@php
    $img = $size === 'small' ? 'size-12' : 'size-16';
    $classes = "text-neutral-500 rounded-full object-cover $img";
@endphp

@if ($avatar)
    <img {{ $attributes->merge(['class' => $classes]) }} src="{{ $avatar }}">
@else
    <x-heroicon-c-user-circle {{ $attributes->merge(['class' => $classes]) }} />
@endif
