@props(['sidebar' => null])

@php
    $showModalForm = false;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta')

    <title>{{ $title ?? null ? $title . ' | ' . config('app.name') : config('app.name') }}</title>

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
    <div x-data="{ 'showPostForm': false }" class="flex min-h-screen">
        <livewire:layout.navigation />

        <!-- Page Content -->
        <main {{ $attributes->merge(['class' => 'flex-1 w-full h-full pb-20 sm:pb-0']) }}>
            {{ $slot }}
        </main>

        {{-- Widget Sidebar --}}
        @if ($sidebar)
            <x-sidebar />
        @endif

        <x-ask-floating-button class="fixed bottom-20 right-6" />
        <livewire:layout.mobile-navigation />

        {{-- Post Form Modal --}}
        <template x-if="showPostForm" x-trap.noscroll="showPostForm">
            <div class="fixed left-0 top-0 z-40 h-screen w-full overflow-y-hidden bg-gray-700/60">
                <div class="mt-8 flex justify-center">
                    <livewire:post-form />
                </div>
            </div>
        </template>
    </div>

    @livewireScripts
</body>

</html>
