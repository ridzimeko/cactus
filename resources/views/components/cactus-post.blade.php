@props([
    'name',
    'username',
    'date',
    'text',
    'avatar' => null,
    'image' => null,
    'post_menu' => null,
    'post_actions' => null,
])

@php
    $fullTime = null;

    $current_time = time(); // Current time in seconds

    $seconds = $current_time - strtotime($date);
    $days = floor($seconds / (60 * 60 * 24));
    $hours = floor($seconds / (60 * 60));
    $minutes = floor($seconds / 60);

    if ($days > 0) {
        $fullTime = $days . ' days ago';
    } elseif ($hours > 0) {
        $fullTime = $hours . ' hours ago';
    } else {
        $fullTime = $minutes . ' minutes ago';
    }
@endphp

<article x-data="{ openLightbox: false }" class="flex gap-5">
    {{-- Post avatar --}}
    <div class="flex-shrink-0">
        <a class="text-base hover:underline" href="{{ route('profile.view', $username) }}">
            <x-user-avatar :avatar="$avatar" class="flex-shrink-0" size="small" />
        </a>
    </div>

    <div class="w-full">
        {{-- Post header --}}
        <header class="relative flex w-full items-center justify-between text-white">
            <div class="flex items-center gap-2 overflow-hidden overflow-ellipsis whitespace-nowrap">
                <a class="whitespace-nowrap font-bold text-white hover:underline" title="{{ $name }}"
                    href="{{ route('profile.view', [$username]) }}">
                    {{ $name }}
                </a>
                <span class="hidden whitespace-nowrap text-gray-400 lg:block">{{ '@' . $username }}</span>
            </div>

            {{-- Post menu --}}
            <div class="flex items-center gap-2">
                <p class="text-sm text-gray-400">{{ $fullTime }}</p>
                @if ($post_menu)
                    <div x-data={showMenu:false}>
                        <div class="cursor-pointer" x-on:click="showMenu=!showMenu" x-on:click.away="showMenu=false">
                            @svg('heroicon-m-ellipsis-horizontal', 'size-5 text-gray-400 group-hover:text-white relative top-0.5')
                        </div>
                        <div x-show="showMenu"
                            class="absolute right-0 top-8 z-10 rounded-md bg-gray-900 px-4 py-2 shadow-lg">
                            {{ $post_menu }}
                        </div>
                    </div>
                @endif
            </div>
        </header>

        {{-- Post content --}}
        <div>
            <p class="break-all text-gray-300">
                {{ $text }}
            </p>

            @if ($image)
                <div class="my-2 h-[320px] w-full rounded-sm bg-gray-800">
                    <img src="{{ $image }}" class="h-full w-full cursor-pointer object-contain"
                        @click="openLightbox = true">
                </div>

                @teleport('body')
                    <div x-show="openLightbox" x-trap.noscroll="openLightbox">
                        <livewire:image-lightbox :src="$image" />
                    </div>
                @endteleport
            @endif
        </div>

        {{-- Post actions --}}
        <div class="flex items-center gap-2">
            {{ $post_actions }}
        </div>
    </div>
</article>
