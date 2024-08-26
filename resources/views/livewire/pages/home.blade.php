<?php

use App\Models\Question;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('layouts.app', ['sidebar' => true])] #[Title('Beranda')] class extends Component {
    use WithPagination;

    #[Computed]
    public $questions;

    public int $page;

    public function mount()
    {
        $this->page = 1;
        $this->questions = collect()->push(...$this->posts()->items());
    }

    #[Computed]
    public function posts()
    {
        return Question::with(['user'])
            ->withCount(['answers'])
            ->latest()
            ->paginate(perPage: 15, page: $this->page);
    }

    public function loadMore()
    {
        $this->page += 1;
        $this->questions->push(...$this->posts()->items());
    }
}; ?>

<div class="m-6 flex flex-col gap-8">
    @foreach ($this->questions as $question)
        <livewire:post.question-post wire:key="{{ $question->id }}" :$question />
    @endforeach
    @if ($this->posts->hasMorePages())
        <div x-intersect.full="$wire.loadMore()" class="mx-auto">
            <div wire:loading wire:target="loadMore" class="loading-indicator">
                <livewire:placeholder class="mx-auto" />
            </div>
        </div>
    @endif
</div>
