<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component
{
    public User $user;

    #[Locked]
    public $username;

    public function mount()
    {
        $this->user = User::with(['questions.answers', 'answers'])
            ->where('username', $this->username)
            ->firstOrFail();
    }
}; ?>

<div>
    <div class="flex gap-10 px-6 pt-6">
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

    <div class="px-6" x-data="{ type: 'questions' }">
        <div class="sticky top-0 mt-12 flex items-center gap-4 border-b border-b-neutral-600 bg-gray-950 text-white">
            <p x-on:click="type = 'questions'" class="cursor-pointer pb-2">{{ $this->user->questions->count() }}
                Pertanyaan</p>
            <p x-on:click="type = 'answers'" class="cursor-pointer pb-2">{{ $this->user->answers->count() }} Jawaban
            </p>
        </div>

        <div>
            <div class="mt-6 flex flex-col gap-4" x-show="type === 'answers'">
                @foreach ($user->answers as $a)
                <livewire:answer-post :answer="$a" />
                @endforeach
            </div>

            <div class="mt-6 flex flex-col gap-4" x-show="type === 'questions'">
                @foreach ($this->user->questions as $q)
                <livewire:question-post :question="$q" />
                @endforeach
            </div>
        </div>
    </div>
</div>