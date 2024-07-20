<?php

use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new class extends Component {
    #[Locked]
    public $authId;

    #[Locked]
    public $url;

    public Question $question;

    public function mount()
    {
        $this->authId = Auth::user()->id;
        $this->url = request()->url();
    }

    public function delete()
    {
        if ($this->question->user_id != Auth::user()->id) {
            return response("You're not authorized to delete this question", 403);
        }

        $this->question->delete();
        return $this->redirect($this->url, true);
    }
}; ?>

<x-cactus-post :name="$question->user->name" :username="$question->user->username" :text="$question->text" :date="$question->updated_at" :avatar="$question->user->profile_img"
    :image="$question->image">
    <x-slot name="post_menu">
        @if ($question->user_id === $authId)
            <button class="flex items-center gap-2" title="Hapus post" wire:click="delete">
                @svg('heroicon-s-trash', ['class' => 'size-5']) Hapus
            </button>
        @endif
    </x-slot>
    <x-slot name="post_actions">
        <a href="{{ route('question.view', ['question_id' => $question->id]) }}" wire:navigate
            class="mt-1 flex max-w-fit gap-2 text-[14px] text-gray-400 hover:text-gray-700">
            @svg('heroicon-s-arrow-uturn-left', ['class' => 'size-4 align-middle'])
            <span>{{ $question->answers_count ?? 0 }} Jawaban</span>
        </a>
    </x-slot>
</x-cactus-post>
