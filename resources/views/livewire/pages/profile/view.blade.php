<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    #[Computed]
    public $user;

    public $username;

    public function mount()
    {
        $this->user = User::with(['questions.answers', 'answers'])
            ->where('username', $this->username)
            ->firstOrFail();
        // $this->questions = $this->user->questions;
    }
}; ?>

<div>
    <div class="flex gap-10 pt-2">
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

    <div x-data="{ type: 'questions' }">
        <div class="sticky top-0 mt-12 flex items-center gap-4 border-b border-b-neutral-600 bg-gray-950 text-white">
            <p x-on:click="type = 'questions'" class="cursor-pointer pb-2">{{ $this->user->questions->count() }}
                Pertanyaan</p>
            <p x-on:click="type = 'answers'" class="cursor-pointer pb-2">{{ $this->user->answers->count() }} Jawaban
            </p>
        </div>

        <div class="mt-6 flex flex-col gap-4">
            <div x-show="type === 'answers'">
                @foreach ($user->answers as $a)
                    <x-cactus-post :name="$user['name']" :username="$user['username']" :text="$a['text']" :id="$a['id']"
                        :date="$a['updated_at']" :avatar="$user['profile_img']" :image="$a['image']" size="small" type="answer" />
                @endforeach
            </div>

            <div x-show="type === 'questions'">
                @foreach ($this->user->questions as $q)
                    <x-cactus-post :name="$user['name']" :username="$user['username']" :text="$q['text']" :id="$q['id']"
                        :date="$q['updated_at']" :avatar="$user['profile_img']" :image="$q['image']" :repliesCount="$q->answers->count()" size="small"
                        type="question" />
                @endforeach
            </div>
        </div>
    </div>
</div>
