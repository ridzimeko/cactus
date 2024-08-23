<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public $class;
    public $username;
    public $showPostForm;

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

<nav
    class="{{ $class }} sticky top-0 z-30 hidden max-h-screen flex-col overflow-y-auto border-r-2 border-gray-800 p-6 sm:flex lg:max-w-[280px]">
    <div class="flex-grow">
        <x-cactus-logo>
            <div class="hidden lg:block">
                <h1 class="my-0 text-xl font-bold">Cactus</h1>
                <p class="my-0 text-lg font-semibold">Forum Tanya Jawab</p>
            </div>
        </x-cactus-logo>
        <div class="flex flex-col gap-2">
            <x-nav-link :active="request()->routeIs('home')" icon="heroicon-o-home" active_icon="heroicon-m-home" :href="route('home')" wire:navigate>Beranda</x-nav-link>
            <x-nav-link :active="request()->routeIs('search')" icon="heroicon-o-magnifying-glass" active_icon="heroicon-m-magnifying-glass" :href="route('search')"
                wire:navigate>Cari</x-nav-link>

            <x-nav-link :active="request()->routeIs('notification')" icon="heroicon-o-bell" active_icon="heroicon-s-bell" :href="route('notification')" wire:navigate>Notifikasi</x-nav-link>
            <x-nav-link :active="request()->path() === 'user/' . $username" icon="heroicon-o-user" active_icon="heroicon-s-user" :href="route('profile.view', [$username])" wire:navigate>Profil</x-nav-link>
            <x-primary-button x-on:click="showPostForm = true" class="mt-6 flex gap-4 items-center" type="button">
                @svg('heroicon-o-pencil-square', 'size-8')
                <span class="hidden lg:block">Tanya</span>
            </x-primary-button>
        </div>
    </div>
</nav>