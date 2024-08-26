<?php

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    public $query;
    public $page;

    #[Computed]
    public $results;

    public function mount()
    {
        $this->page = 1;
        $this->results = collect()->push(...$this->loadUsers()->items());
    }

    public function loadUsers()
    {
        return User::whereAny(['name', 'username'], 'like', "%$this->query%")
            ->latest()
            ->paginate(perPage: 15, page: $this->page);
    }

    public function loadMore()
    {
        $this->page += 1;
        $this->results->push(...$this->loadUsers()->items());
    }
}; ?>

<div>
    @if ($this->results->count() >= 1)
        @foreach ($this->results as $q)
            <x-user-list wire:key="{{ $q['id'] }}" :name="$q['name']" :username="$q['username']" :avatar="$q['profile_img']" />
        @endforeach
        @if ($this->loadUsers()->hasMorePages())
            <div x-intersect.full="$wire.loadMore()" class="mx-auto text-center">
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
