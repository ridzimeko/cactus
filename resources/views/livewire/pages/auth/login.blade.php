<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
}; ?>

@extends('layouts.partials.auth')

@section('header', 'Selamat Datang kembali di Cactus')
@section('subheader', 'Untuk tetap terhubung dengan kami, silahkan Login dengan info pribadi.')

@section('form')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Cactus Head --}}
    <x-cactus-logo class="mb-4">
        <h1 class="my-0 text-3xl font-bold">CACTUS</h1>
    </x-cactus-logo>

    <p class="mb-4 text-lg text-gray-300">Login akun untuk melanjutkan</p>

    <form wire:submit="login">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="mt-1 block w-full" type="email" name="email"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="mt-1 block w-full" type="password"
                name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mt-4 block">
            <label for="remember_me" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember_me" type="checkbox"
                    class="rounde border-gray-700 bg-gray-900 text-green-800 shadow-sm focus:ring-green-800 focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-400">{{ __('Ingat akun saya') }}</span>
            </label>
        </div>

        <x-primary-button class="mt-2 w-full">LOGIN</x-primary-button>

        <a class="mt-5 block w-max rounded-md text-sm text-gray-200 hover:underline focus:outline-none"
            href="{{ route('register') }}">
            {{ __('Belum punya akun? Daftar akun') }}
        </a>
    </form>
@endsection
