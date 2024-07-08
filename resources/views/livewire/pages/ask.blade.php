<?php

use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.app')] #[Title('Buat pertanyaan')] class extends Component {
    use WithFileUploads;

    #[Locked]
    public $profile_img;

    #[Locked]
    public $name;

    #[Validate]
    public $question;

    #[Validate]
    public $question_image;

    public function mount()
    {
        $this->profile_img = Auth::user()->profile_img;
        $this->name = Auth::user()->name;
    }

    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:450'],
            'question_image' => ['file', 'nullable', Rule::imageFile()->max('1mb')],
        ];
    }

    public function messages(): array
    {
        return [
            'question' => 'Tulis pertanyaan yang ingin kamu tanyakan...',
            'question.max' => 'Maaf kamu hanya bisa menulis pertanyaan maksimal 450 karakter',
            'question_image.max' => 'Ukuran gambar terlalu besar! maks 1 Mb',
            'question_image.image' => 'File yang kamu kirim bukan format gambar',
        ];
    }

    public function create()
    {
        $validated = $this->validate();

        if ($this->question_image) {
            $validated['question_image'] = '/storage/' . $this->question_image->store('posts', 'public');
        }

        Question::create([
            'user_id' => Auth::id(),
            'text' => $this->question,
            'image' => $validated['question_image'] ?? null,
        ]);

        return $this->redirectRoute('home', navigate: true);
    }
}; ?>

<div class="ml-8 mt-12 flex gap-6 text-white">
    <x-user-avatar :avatar="$profile_img" class="flex-shrink-0" />
    <form wire:submit="create">
        @csrf

        <div class="relative">
            <p class="mb-2 ml-1 text-lg text-white">{{ $name }}</p>
            <textarea wire:model.live="question" x-data @keyup.ctrl.enter="$event.target.form.submit()"
                class="rounded-md bg-transparent pb-12" name="question" cols="60" rows="10"
                placeholder="Tulis Pertanyaanmu Disini..."></textarea>
            <div class="mt-4 flex items-center gap-4">
                <label for="ask-attachment" class="flex w-max items-center rounded-full bg-gray-800 px-4 py-3">
                    <div class="flex cursor-pointer items-center gap-2">
                        @svg('heroicon-o-photo', ['class' => 'size-6'])
                        <span>Lampirkan gambar</span>
                    </div>
                    <input wire:model="question_image" type="file" name="question_image" id="ask-attachment" hidden>
                </label>
                <button type="submit" class="rounded-full border bg-slate-200 px-6 py-2 text-black">Posting!</button>
            </div>
            <p class="mt-4" wire:loading wire:target="question_image">Mengupload gambar...</p>
        </div>
        <x-input-error :messages="$errors->get('question')" class="mt-2" />
        <x-input-error :messages="$errors->get('question_image')" class="mt-2" />
    </form>
</div>
