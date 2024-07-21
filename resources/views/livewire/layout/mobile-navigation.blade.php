<?php

use App\Livewire\Actions\Logout;
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
    <x-nav-link icon-size="8" :active="request()->routeIs('home')" icon="heroicon-c-home" :href="route('home')" wire:navigate />
    <x-nav-link icon-size="8" :active="request()->routeIs('notification')" icon="heroicon-s-bell" :href="route('notification')" wire:navigate />
    <x-nav-link icon-size="8" :active="request()->routeIs('ask')" icon="heroicon-s-chat-bubble-bottom-center-text" :href="route('ask')"
        wire:navigate />
    <x-nav-link icon-size="8" :active="request()->routeIs('search')" icon="heroicon-o-magnifying-glass" :href="route('search')" wire:navigate />
    <x-nav-link icon-size="8" :active="request()->path() === 'user/' . $username" icon="heroicon-s-user" :href="route('profile.view', [$username])" wire:navigate />
</div>
