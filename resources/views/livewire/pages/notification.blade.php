<?php

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.app', ['sidebar' => true])] #[Title('Notifikasi')] class extends Component
{
    public $notifications;

    public function mount()
    {
        $this->notifications = Notification::with(['answer.user'])
            ->where('user_id', Auth::user()->id)
            ->get();
    }
}; ?>

<div class="py-4">
    <div class="flex items-center justify-between border-b border-gray-400 px-6 pb-2 text-white">
        <h2 class="text-xl">Notifikasi</h2>
    </div>

    @foreach ($notifications as $n)
    <x-notification-post :name="$n->answer->user->name" :text="$n->answer->text" :username="$n->answer->user->username" :avatar="$n->answer->user->profile_img" :date="$n->answer->updated_at" :questionId="$n->answer->question_id" />
    @endforeach
</div>