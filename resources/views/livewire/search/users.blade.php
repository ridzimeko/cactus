<?php

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Reactive;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    public $query;

    #[Computed]
    public $results;

    public function mount()
    {
        $this->results = User::whereAny(['name', 'username'], 'like', "%$this->query%")
                ->orderByDesc('updated_at')
                ->get();
    }
}; ?>

<div>
    @if ($this->results->count() >= 1)
        @foreach ($this->results as $q)
            <x-user-list :name="$q['name']" :username="$q['username']" :avatar="$q['profile_img']" />
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
