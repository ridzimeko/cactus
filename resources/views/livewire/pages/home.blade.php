<?php

use App\Models\Question;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.app', ['sidebar' => true])] #[Title('Beranda')] class extends Component
{
    public $questions;

    public function mount()
    {
        $this->questions = Question::with(['user'])->withCount(['answers'])->latest()->get();
    }
}; ?>

<div class="m-6 flex flex-col gap-8">
    @foreach ($this->questions as $q)
    <livewire:question-post :question="$q" />
    @endforeach
</div>