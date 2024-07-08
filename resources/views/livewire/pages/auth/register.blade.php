<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $username = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:20', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('home', absolute: false));
    }
}; ?>

@extends('layouts.partials.auth')

@section('header', 'Selamat Datang di Cactus')
@section('subheader', 'Forum Cactus, oasis pengetahuan untuk semua pertanyaan Anda.')

@section('form')
    {{-- Cactus Head --}}
    <x-cactus-logo class="mb-4">
        <h1 class="my-0 text-3xl font-bold">CACTUS</h1>
    </x-cactus-logo>

    <p class="mb-4 text-lg text-gray-300">Daftar untuk bergabung ke forum Cactus</p>

    <form wire:submit="register">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input wire:model="name" id="name" class="mt-1 block w-full" type="text" name="name" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input wire:model="username" id="username" class="mt-1 block w-full" type="text" name="username"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="mt-1 block w-full" type="email" name="email" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="password" id="password" class="mt-1 block w-full" type="password" name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="mt-1 block w-full"
                type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="mt-6 w-full">
            {{ __('Register') }}
        </x-primary-button>

        <a class="mt-4 block w-max rounded-md text-sm text-gray-200 hover:underline focus:outline-none"
            href="{{ route('login') }}">
            {{ __('Sudah daftar? Silahkan login') }}
        </a>
    </form>
@endsection
