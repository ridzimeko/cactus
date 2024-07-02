@props(['type' => 'text'])

@php
    $classes = "border-0 border-b-2 border-gray-600 w-full bg-transparent focus:border-b-gray-300 transition focus:outline-none focus:ring-0 text-neutral-300 pl-0";
@endphp


<input type="{{ $type }}" {{ $attributes->merge(['class' => $classes ]) }} />
