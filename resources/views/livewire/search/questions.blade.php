<?php

use App\Models\Question;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Volt\Component;

new class extends Component {
    public $query;

    #[Computed]
    public $results;

    public function mount()
    {
        $this->results = Question::with(['user'])
            ->where('text', 'like', "%$this->query%")
            ->orderByDesc('updated_at')
            ->get();
    }
}; ?>

<div>
    @if ($this->results->count() >= 1)
        @foreach ($this->results as $q)
            <x-cactus-post :name="$q['user']['name']" :username="$q['user']['username']" :avatar="$q['user']['profile_img']" :date="$q['updated_at']" :text="$q['text']"
                :repliesCount="$q->answers->count()" :id="$q['id']" type="question" :image="$q['image']" />
        @endforeach
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
