<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public $username;

    public function mount()
    {
        $this->username = Auth::user()->username;
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav class="sticky top-0 z-30 flex max-h-screen w-[320px] flex-col overflow-y-auto border-r-2 border-gray-800 p-6">
    <div class="flex-grow">
        <x-cactus-logo>
            <h1 class="my-0 text-xl font-bold">Cactus</h1>
            <p class="my-0 text-lg font-semibold">Forum Tanya Jawab</p>
        </x-cactus-logo>
        <x-nav-link :active="request()->routeIs('home')" icon="heroicon-c-home" :href="route('home')" wire:navigate>Beranda</x-nav-link>
        <x-nav-link :active="request()->path() === 'user/' . $username" icon="heroicon-s-user" :href="route('profile.view', [$username])" wire:navigate>Profil</x-nav-link>
        <x-nav-link :active="request()->routeIs('notification')" icon="heroicon-s-bell" :href="route('notification')" wire:navigate>Notifikasi</x-nav-link>
        <x-nav-link :active="request()->routeIs('ask')" icon="heroicon-s-chat-bubble-bottom-center-text" :href="route('ask')"
            wire:navigate>Tanya</x-nav-link>
        <x-nav-link :active="request()->routeIs('search')" icon="heroicon-o-magnifying-glass" :href="route('search')"
            wire:navigate>Cari</x-nav-link>
    </div>

    <div>
        <x-nav-link wire:click="logout" class="w-full" icon="heroicon-o-arrow-left-on-rectangle">Logout</x-nav-link>
    </div>
</nav>
