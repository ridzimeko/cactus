<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public $class;
    public $username;

    public function mount()
    {
        $this->username = Auth::user()->username;
    }
}; ?>

<div
    class="fixed bottom-0 left-0 z-30 flex w-screen items-center justify-evenly overflow-auto border-t-2 border-t-gray-700 bg-gray-950 py-2 sm:hidden">
    <x-nav-link class="!size-12" :active="request()->routeIs('home')" icon="heroicon-o-home" active_icon="heroicon-m-home" :href="route('home')"
        wire:navigate />
    <x-nav-link class="!size-12" :active="request()->routeIs('search')" icon="heroicon-o-magnifying-glass"
        active_icon="heroicon-s-magnifying-glass" :href="route('search')" wire:navigate />
    <x-nav-link class="!size-12" :active="request()->routeIs('notification')" icon="heroicon-o-bell" active_icon="heroicon-s-bell" :href="route('notification')"
        wire:navigate />
    <x-nav-link class="!size-12" :active="request()->path() === 'user/' . $username" icon="heroicon-o-user" active_icon="heroicon-s-user"
        :href="route('profile.view', [$username])" wire:navigate />
</div>
