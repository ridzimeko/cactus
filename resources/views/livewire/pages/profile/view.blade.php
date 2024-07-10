<?php

use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    public User $user;

    public $type;

    #[Locked]
    public $username;

    public function rendering(View $view): void
    {
        $view->title("{$this->user->name} (@{$this->username})");
    }

    public function mount(): void
    {
        $this->user = User::with(['questions.answers', 'answers'])
            ->where('username', $this->username)
            ->firstOrFail();
        $this->type = 'questions';
    }
}; ?>

<div class="mx-auto max-w-[820px]">
    <div class="mb-12 flex gap-10 px-6 pt-8">
        <div class="flex-shrink-0">
            <x-user-avatar :avatar="$user['profile_img']" class="!size-40" />
            @if ($user['username'] === Auth::user()->username)
                <x-secondary-button wire:navigate href="{{ route('profile.edit') }}" class="mx-auto block w-max">Edit
                    Profil</x-secondary-button>
            @endif
        </div>

        <div class="break-all pt-1 text-white">
            <h2 class="text-2xl">{{ $user['name'] }}</h2>
            <p class="mb-4 text-base text-gray-400">{{ $user['username'] }}</p>
            <p class="mb-4 flex items-center gap-2">
                @svg('heroicon-c-map-pin', ['class' => 'size-6'])
                {{ $this->user['location'] }}
            </p>
            <p>{{ $this->user['bio'] }}</p>
        </div>
    </div>

    <div x-data="{
        type: $wire.entangle('type'),
        active: 'after:content-[\'\'] after:border-b after:border-b-slate-200 after:w-full after:absolute after:left-0 after:-bottom-2 font-bold'
    }">
        <div
            class="relative flex items-center justify-center gap-10 border-b border-b-neutral-600 py-2 text-center text-white">
            <p x-bind:class="type === 'questions' ? active : ''" class="relative cursor-pointer"
                x-on:click="type = 'questions'">{{ $user->questions->count() }} Pertanyaan</p>
            <p x-bind:class="type === 'answers' ? active : ''" class="relative cursor-pointer"
                x-on:click="type = 'answers'">
                {{ $user->answers->count() }} Jawaban
            </p>
        </div>

        <div class="px-6 pb-8 pt-2">
            <div class="mt-6 flex flex-col gap-6" x-show="type === 'answers'">
                @foreach ($user->answers as $a)
                    <livewire:answer-post :answer="$a" />
                @endforeach
            </div>

            <div class="mt-6 flex flex-col gap-6" x-show="type === 'questions'">
                @foreach ($this->user->questions as $q)
                    <livewire:question-post :question="$q" />
                @endforeach
            </div>
        </div>
    </div>
</div>
