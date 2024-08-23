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

<div class="w-[600px] border border-gray-600 bg-gray-950 text-white">
    <div class="flex items-center gap-4 border-b border-gray-600 px-4 py-2">
        <x-heroicon-s-x-mark x-on:click="showPostForm = false" class="size-8 cursor-pointer align-middle text-gray-400" />
        <x-user-avatar size="small" :avatar="$profile_img" class="flex-shrink-0" />
    </div>

    <form wire:submit="create">
        @csrf
        <div class="relative">
            <textarea wire:model.live="question" x-data @keyup.ctrl.enter="$event.target.form.submit()"
                class="h-40 w-full resize-none border-0 bg-transparent pb-12 text-lg placeholder-gray-400 focus:outline-none focus:ring-0"
                name="question" placeholder="Tulis Pertanyaanmu Disini..."></textarea>
            <div class="flex flex-col gap-4 border-t border-t-gray-600 px-4 py-2">
                <div>
                    <p class="mt-4" wire:loading wire:target="question_image">Mengupload gambar...</p>
                    <x-input-error :messages="$errors->get('question')" class="mt-2" />
                    <x-input-error :messages="$errors->get('question_image')" class="mt-2" />
                </div>
                <div class="mb-2 flex h-10 justify-between">
                    <div class="flex items-center gap-2">
                        <label for="ask-attachment" class="flex w-max cursor-pointer items-center rounded-full py-3"
                            title="Tambahkan gambar" aria-hidden="true">
                            @svg('heroicon-o-photo', ['class' => 'size-6'])
                            <input wire:model="question_image" type="file" name="question_image" id="ask-attachment"
                                hidden>
                        </label>
                    </div>
                    <x-primary-button rounded="true" type="submit">Posting!</x-primary-button>
                </div>
            </div>
        </div>
    </form>
</div>
