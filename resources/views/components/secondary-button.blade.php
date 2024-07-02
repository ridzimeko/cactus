@props(['href' => null])

@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->merge(['class' => 'block bg-slate-200 text-black px-6 py-2 rounded-full mt-8']) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => 'bg-slate-200 text-black px-6 py-2 rounded-full mt-8']) }}>
        {{ $slot }}
    </button>
@endif
