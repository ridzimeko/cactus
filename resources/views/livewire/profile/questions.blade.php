<?php

use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new class extends Component {
    #[Locked]
    public $userId;

    #[Locked]
    public $results;

    public $page;

    public function mount()
    {
        $this->results = collect()->push(...$this->loadQuestions()->items());
        $this->page = 1;
    }

    public function loadMore()
    {
        $this->page += 1;
        $this->results->push(...$this->loadQuestions()->items());
    }

    #[Computed]
    public function loadQuestions()
    {
        return Question::with('user')->whereHas('user', function (Builder $query) {
            return $query->where('id', '=', $this->userId);
        })->latest()->paginate(perPage: 15, page: $this->page);
    }
}; ?>

<div class="mt-6 flex flex-col gap-6">
    @foreach ($this->results as $question)
    <livewire:post.question-post :key="$question->id" :$question />
    @endforeach
    @if ($this->loadQuestions()->hasMorePages())
    <div x-intersect.full="$wire.loadMore()" class="mx-auto text-center">
        <div wire:loading wire:target="loadMore" class="loading-indicator">
            <livewire:placeholder />
        </div>
    </div>
    @endif
</div>