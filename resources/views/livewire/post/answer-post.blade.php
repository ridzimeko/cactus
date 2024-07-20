<?php

use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new class extends Component {
    #[Locked]
    public $authId;

    #[Locked]
    public $url;

    public Answer $answer;

    public function mount()
    {
        $this->authId = Auth::user()->id;
        $this->url = request()->url();
    }

    public function delete()
    {
        if ($this->answer->user_id != $this->authId) {
            return response("You're not authorized to delete this answer", 403);
        }

        $this->answer->delete();
        $this->redirect($this->url, true);
    }
}; ?>


<x-cactus-post :name="$answer->user->name" :username="$answer->user->username" :text="$answer->text" :date="$answer->updated_at" :avatar="$answer->user->profile_img"
    :image="$answer->image">
</x-cactus-post>
