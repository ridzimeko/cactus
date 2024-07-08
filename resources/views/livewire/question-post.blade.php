<?php

use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new class extends Component
{
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
        if ($this->question->user_id != Auth::user()->id) return response("You're not authorized to delete this question", 403);

        $this->question->delete();
        return $this->redirect($this->url, true);
    }

    protected function getformattedTime($date): string
    {
        $fullTime = null;

        $current_time = time(); // Current time in seconds

        $seconds = $current_time - strtotime($date);
        $days = floor($seconds / (60 * 60 * 24));
        $hours = floor($seconds / (60 * 60));
        $minutes = floor($seconds / 60);

        if ($days > 0) {
            $fullTime = $days . ' days ago';
        } elseif ($hours > 0) {
            $fullTime = $hours . ' hours ago';
        } else {
            $fullTime = $minutes . ' minutes ago';
        }

        return $fullTime;
    }
}; ?>

<div>
    <article class="group flex gap-6">
        <div class="flex-shrink-0">
            <a class="text-base hover:underline" href="{{ route('profile.view', $question->user->username) }}">
                <x-user-avatar :avatar="$question->user->profile_img" class="flex-shrink-0" />
            </a>
        </div>

        <div class="w-full text-white">
            <header class="flex items-center gap-2">
                <a class="text-lg text-gray-200 hover:underline" href="{{ route('profile.view', [$question->user->username]) }}">
                    {{ $question->user->name }}
                </a>
                <span class="text-gray-400">{{ '@' . $question->user->username }}</span>
                <span class="text-gray-400 text-base">{{ $this->getformattedTime($question->updated_at) }}</span>
                @if ($question->user_id === $authId)
                <div class="opacity-0 transition-all group-hover:opacity-100">
                    <button title="Hapus post" wire:click="delete">
                        @svg('heroicon-s-trash', ['class' => 'size-5'])
                    </button>
                </div>
                @endif
            </header>
            <p class="break-all">{{ $question->text }}</p>
            @if ($question->image)
            <div class="my-2 h-[320px] w-full rounded-sm bg-gray-800">
                <a href="{{ $question->image }}" target="_blank" rel="noopener noreferrer">
                    <img src="{{ $question->image }}" class="h-full w-full object-contain">
                </a>
            </div>
            @endif

            <a href="{{ route('question.view', ['question_id' => $question->id]) }}" wire:navigate>{{ $question->answers_count ?? 0 }}
                jawaban</a>
        </div>
    </article>
</div>