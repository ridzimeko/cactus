@props(['rounded' => true, 'class' => ''])

<button {{ $attributes }} @class([
    'bg-green-800 px-4 py-2 text-white hover:bg-green-900 disabled:bg-green-950 disabled:cursor-default cursor-pointer',
    'rounded-md' => !$rounded,
    'rounded-full' => $rounded,
    $class,
])>
    {{ $slot }}
</button>
