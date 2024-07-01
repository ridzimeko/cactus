<?php

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

use function Livewire\Volt\computed;

new #[Layout('layouts.app', ['sidebar' => true])] class extends Component {

    #[Computed]
    public function questions()
    {
        return Question::withCount(['answers'])->orderByDesc('updated_at')->get();
    }

}; ?>

<div class="flex flex-col gap-8">
        @foreach ($this->questions as $q)
            <x-cactus-post 
                :text="$q->text" 
                :name="$q->user->name" 
                :username="$q->user->username"
                :date="$q->updated_at" 
                :image="$q->image"
                :repliesCount="$q->answers_count"
                :avatar="$q->user->profile_img"
                :id="$q->id"
                type="question"
            />
        @endforeach
    </div>