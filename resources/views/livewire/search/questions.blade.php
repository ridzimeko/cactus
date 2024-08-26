<?php

use App\Models\Question;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component {
    public $query;
    public $page;

    #[Computed]
    public $results;

    public function mount()
    {
        $this->page = 1;
        $this->results = collect()->push(...$this->loadQuestions()->items());
    }

    public function loadQuestions()
    {
        return Question::with(['user'])
            ->where('text', 'like', "%$this->query%")
            ->latest()
            ->paginate(perPage: 15, page: $this->page);
    }

    public function loadMore()
    {
        $this->page += 1;
        $this->results->push(...$this->loadQuestions()->items());
    }
}; ?>

<div class="flex flex-col gap-6">
    @if ($this->results->count() >= 1)
        @foreach ($this->results as $question)
            <livewire:post.question-post wire:key="{{ $question['id'] }}" :$question />
        @endforeach
        @if ($this->loadQuestions()->hasMorePages())
            <div x-intersect.full="$wire.loadMore()" class="mx-auto">
                <div wire:loading wire:target="loadMore" class="loading-indicator">
                    <livewire:placeholder />
                </div>
            </div>
        @endif
    @else
        <div class="mx-8 flex flex-col items-center gap-4 break-all text-white">
            @svg('heroicon-o-question-mark-circle', ['class' => 'size-28'])
            <h1 class="text-3xl">Pencarian tidak ditemukan</h1>
            <p class="text-base">Maaf kami tidak menemukan pencarian dengan kata kunci :
                {{ $query }}
            </p>
        </div>
    @endif
</div>
