<?php

use Livewire\Volt\Component;

new class extends Component {
    public $src;
}; ?>

<div class="fixed left-0 top-0 z-40 block h-screen w-full overflow-y-hidden bg-gray-700/80">
    <x-heroicon-s-x-mark x-on:click="openLightbox = false"
        class="size-8 absolute right-8 top-8 cursor-pointer drop-shadow" />
    <div class="flex h-full flex-col justify-center">
        <div class="flex items-center justify-center py-2">
            <img @click.outside="openLightbox = false" src="{{ $src }}" alt="Login illustration"
                class="max-h-screen" />
        </div>
    </div>
</div>
