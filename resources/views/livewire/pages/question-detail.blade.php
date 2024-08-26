<?php

use App\Models\Answer;
use App\Models\Notification;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('layouts.app', ['sidebar' => true])] class extends Component {
    #[Locked]
    public $question_id;

    #[Locked]
    public $question_from_id;

    #[Locked]
    public $authId;

    #[Locked]
    public $url;

    #[Computed]
    public $answers;

    #[Computed]
    public Question $question;

    public $page;
    #[
        Validate(
            rule: 'required|string|max:450',
            message: [
                'answer' => 'Input jawaban tidak boleh kosong',
                'answer.max' => 'Maaf kamu hanya bisa menulis jawaban maksimal 450 karakter',
            ],
        ),
    ]
    public $answerInput;

    public function rendering(View $view): void
    {
        $view->title($this->question->text);
    }

    public function mount()
    {
        $this->question = Question::with('user')->findOrFail($this->question_id);
        $this->answers = collect()->push(...$this->loadAnswers()->items());
        $this->question_from_id = $this->question->user->id;
        $this->authId = Auth::user()->id;
        $this->url = request()->url();
        $this->page = 1;
    }

    #[Computed]
    protected function loadAnswers()
    {
        return $this->question->answers()->with('user')->paginate(15, page: $this->page);
    }

    public function loadMore()
    {
        $this->page += 1;
        $this->answers->push(...$this->loadAnswers()->items());
    }

    public function createAnswer()
    {
        $this->validate();

        $answer = Answer::create([
            'user_id' => $this->authId,
            'text' => $this->answerInput,
            'question_id' => $this->question_id,
        ]);

        // Kirim notifikasi jika bukan dari user yang sama
        if ($this->authId != $this->question_from_id) {
            Notification::create([
                'user_id' => $this->question_from_id,
                'answer_id' => $answer->id,
                'created_at' => now(),
            ]);
        }

        // Empty answer input
        $this->answerInput = '';

        $this->redirect($this->url, true);
    }
}; ?>

<div class="flex flex-col">
    <div class="border-b border-b-gray-600 px-6 pb-4 pt-6">
        <x-cactus-post :name="$this->question->user->name" :username="$this->question->user->username" :text="$this->question->text" :date="$this->question->updated_at" :avatar="$this->question->user->profile_img"
            :image="$this->question->image">
        </x-cactus-post>
    </div>

    <div class="border-b border-b-gray-600 py-6">
        <div class="w-full px-6">
            <x-input-error :messages="$errors->get('answer')" class="mb-2 ml-[65px]" />
            <form wire:submit="createAnswer" class="flex items-center gap-4">
                @csrf

                <x-user-avatar :avatar="Auth::user()->profile_img" class="!size-12" />
                <x-text-input rounded wire:model="answerInput" name="answer" placeholder="Tambahkan balasan..."
                    class="flex-1" />
                <x-primary-button rounded class="px-8">Kirim</x-primary-button>
            </form>
        </div>
    </div>

    <div class="mt-4 flex flex-col gap-8 px-6 pb-8">
        @foreach ($this->answers as $key => $answer)
            <livewire:post.answer-post :key="$answer->id" :$answer />
        @endforeach
        @if ($this->loadAnswers->hasMorePages())
            <div x-intersect.full="$wire.loadMore()" class="mx-auto">
                <div wire:loading wire:target="loadMore" class="loading-indicator">
                    <livewire:placeholder />
                </div>
            </div>
        @endif
    </div>
</div>
