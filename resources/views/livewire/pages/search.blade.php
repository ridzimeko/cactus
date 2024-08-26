<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;

new #[Layout('layouts.app', ['sidebar' => true])] #[Title('Cari')] class extends Component {
    #[Url(as: 'q')]
    public $query;
}; ?>

<div>
    <div class="m-4">
        <x-text-input wire:model.live.debounce.450ms="query" rounded class="w-full" placeholder="Cari" />
    </div>

    <div x-data="{
        category: 'questions',
        active: 'after:content-[\'\'] after:border-b after:border-b-slate-200 after:w-full after:absolute after:left-0 after:-bottom-2 w-full font-bold'
    }">
        <div class="relative grid w-full grid-cols-2 border-b border-b-neutral-600 pb-2 text-center text-white">
            <p x-bind:class="category === 'questions' ? active : ''" class="relative cursor-pointer"
                x-on:click="category = 'questions'">Pertanyaan</p>
            <p x-bind:class="category === 'users' ? active : ''" class="relative cursor-pointer"
                x-on:click="category = 'users'">
                Pengguna</p>
        </div>

        <div class="mx-6 mt-2">
            @if ($query)
                <div class="mt-4 flex w-full flex-col gap-4">
                    <div x-show="category === 'questions'">
                        <livewire:search.questions wire:key="{{ $query }}" :query="$query" lazy>
                    </div>
                    <div x-show="category === 'users'">
                        <livewire:search.users wire:key="{{ $query }}" :query="$query" lazy>
                    </div>
                </div>
            @else
                <div class="mx-8 mt-4 flex flex-col items-center gap-4 break-all text-white">
                    @svg('heroicon-o-magnifying-glass', ['class' => 'size-20'])
                    <p class="text-base">Masukkan kata kunci untuk melakukan pencarian</p>
                </div>
            @endif
        </div>
    </div>
</div>
