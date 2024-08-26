<?php

use App\Models\Answer;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new class extends Component {
    #[Locked]
    public $userId;

    #[Locked]
    public $results;

    public Answer $answers;
    public $page;

    public function mount()
    {
        $this->page = 1;
        // dd($this->loadAnswers());
        $this->results = collect()->push(...$this->loadAnswers()->items());
    }

    public function loadMore()
    {
        $this->page += 1;
        $this->results->push(...$this->loadAnswers()->items());
    }

    #[Computed]
    public function loadAnswers()
    {
        return Answer::with('user')->whereHas('user', function (Builder $query) {
            return $query->where('id', '=', $this->userId);
        })->latest()->paginate(perPage: 15, page: $this->page);
    }
}; ?>

<div class="mt-6 flex flex-col gap-6">
    @foreach ($this->results as $answer)
    <livewire:post.answer-post :key="$answer->id" :$answer />
    @endforeach
    @if ($this->loadAnswers()->hasMorePages())
    <div x-intersect.full="$wire.loadMore()" class="mx-auto text-center">
        <div wire:loading wire:target="loadMore" class="loading-indicator">
            <livewire:placeholder />
        </div>
    </div>
    @endif
</div>