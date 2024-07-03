<?php

use App\Models\Answer;
use App\Models\Notification;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('layouts.app', ['sidebar' => true])] class extends Component {
    public $question_id;

    #[Locked]
    public $question_from_id;

    #[Locked]
    public $user_id;

    #[Computed]
    public Question $question;

    #[
        Validate(
            rule: 'required|string|max:450',
            message: [
                'answer' => 'Input jawaban tidak boleh kosong',
                'answer.max' => 'Maaf kamu hanya bisa menulis jawaban maksimal 450 karakter',
            ],
        ),
    ]
    public $answer;

    public function mount()
    {
        $this->question = Question::with(['user', 'answers.user'])->findOrFail($this->question_id);
        $this->question_from_id = $this->question->user->id;
        $this->user_id = Auth::user()->id;
    }

    public function createAnswer()
    {
        $this->validate();

        $answer = Answer::create([
            'user_id' => $this->user_id,
            'text' => $this->answer,
            'question_id' => $this->question_id,
        ]);

        // Kirim notifikasi jika bukan dari user yang sama
        if (Auth::user()->id != $this->user_id) {
            Notification::create([
                'user_id' => $this->user_id,
                'answer_id' => $answer->id,
                'created_at' => now(),
            ]);
        }

        $this->answer = '';
    }
}; ?>

<div class="flex flex-col">
    <div class="max-h-full flex-1">
        <div class="border-b border-b-gray-600 px-4 pt-6 text-white">
            <p class="text-lg">{{ $question->text }}</p>
            <p class="my-1 text-base">{{ $question->answers->count() }} balasan</p>
            @if ($question->image)
                <div class="my-2 h-[320px] w-full rounded-sm bg-gray-800">
                    <a href="{{ $question->image }}" target="_blank" rel="noopener noreferrer">
                        <img src="{{ $question->image }}" class="h-full w-full object-contain">
                    </a>
                </div>
            @endif


        </div>

        <div class="border-b border-b-gray-600 py-6">
            <div class="w-full px-6">
                <x-input-error :messages="$errors->get('answer')" class="mb-2 ml-[65px]" />
                <form wire:submit="createAnswer" class="flex items-center gap-4">
                    @csrf

                    <x-user-avatar :avatar="Auth::user()->profile_img" class="!size-12" />
                    <x-text-input rounded wire:model="answer" name="answer" placeholder="Tambahkan balasan..."
                        class="flex-1" />
                    <x-primary-button rounded class="px-8">Kirim</x-primary-button>
                </form>
            </div>
        </div>

        <div class="mt-4 flex flex-col gap-8 px-6">
            @foreach ($question->answers as $answer)
                <x-cactus-post :name="$answer['user']['name']" :username="$answer['user']['username']" :avatar="$answer['user']['profile_img']" :date="$answer['created_at']" :text="$answer['text']"
                    :id="$answer['id']" type="answer" />
            @endforeach
        </div>
    </div>
</div>
