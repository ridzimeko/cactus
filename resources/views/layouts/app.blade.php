@props(['sidebar' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta')

    <title>{{ $title ?? config('app.name', 'Cactus') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Favicon --}}
    <link rel="icon" href="/img/cactus.png" type="image/png">

    @livewireStyles

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-950 font-sans text-slate-50 antialiased">
    <div class="flex min-h-screen">
        <livewire:layout.navigation />

        <!-- Page Content -->
        <main {{ $attributes->merge(['class' => 'flex-1 max-w-[800px] min-w-0 py-4 px-6']) }}>
            {{ $slot }}
        </main>

        @if ($sidebar)
            @includeIf('components.sidebar')
        @endif
    </div>

    @livewireScripts
</body>

</html>
