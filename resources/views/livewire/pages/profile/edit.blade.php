<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.app')] #[Title('Edit Profil')] class extends Component {
    use WithFileUploads;

    #[Validate]
    public $name;

    #[Validate]
    public $username;

    #[Validate]
    public $location;

    #[Validate]
    public $bio;

    #[Validate]
    public $profile_img;

    #[Validate]
    public $email;

    protected function user()
    {
        return Auth::user();
    }

    public function mount()
    {
        // Load user data from database

        $this->name = $this->user()->name;
        $this->username = $this->user()->username;
        $this->location = $this->user()->location;
        $this->bio = $this->user()->bio;
        $this->email = $this->user()->email;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'username' => ['required', 'regex:/^\w+$/', 'string', 'max:20', Rule::unique(User::class)->ignore($this->user()->id)],
            'location' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:255'],
            'profile_img' => ['nullable', 'extensions:jpg,png', File::image()->max('1mb')],
        ];
    }

    public function messages(): array
    {
        return [
            'profile_img.max' => 'Maaf, max upload gambar adalah 1mb',
            'profile_img.image' => 'File yang kamu upload bukan gambar!',
            'username' => 'Format username tidak valid. Karakter yang boleh digunakan "huruf, angka dan _"',
            'username.unique' => 'Username ini tidak tersedia',
            'username.max' => 'Username melewati batas maksimal 20 karakter!',
            'email' => 'Format penulisan Email tidak valid',
            'required' => 'Input tidak boleh kosong!',
        ];
    }

    public function update()
    {
        $this->validate();

        // Check uploaded image, if there's no image uploaded use previous image
        if ($this->profile_img) {
            $this->profile_img = '/storage/' . $this->profile_img->store('userImage', 'public');
        } else {
            $this->profile_img = $this->user()->profile_img;
        }

        User::find($this->user()->id)->update([
            'profile_img' => $this->profile_img,
            'name' => $this->name,
            'username' => $this->username,
            'location' => $this->location,
            'bio' => $this->bio,
            'email' => $this->email,
        ]);

        return $this->redirectRoute('profile.view', [$this->username]);
    }
}; ?>

<form wire:submit="update" class="mx-auto w-full max-w-[820px] p-6">
    @csrf

    <label for="profile_img">
        <div class="relative w-max cursor-pointer text-gray-900">
            <x-user-avatar :avatar="$this->user()->profile_img" class="!size-24" />
            @svg('heroicon-o-camera', ['class' => 'size-8 p-1 bg-neutral-300 rounded-full absolute -bottom-2 -right-2'])
        </div>
        <input wire:model="profile_img" name="profile_img" id="profile_img" type="file" accept="image/*" hidden />
    </label>
    <div wire:loading wire:target="profile_img" class="mt-2">Sedang mengunggah gambar...</div>
    <x-input-error :messages="$errors->get('profile_img')" class="mt-2" />

    <div class="mt-8">
        <x-input-label for="name" value="Nama" class="!text-base !text-gray-500" />
        <x-underline-text-input wire:model.blur="name" name="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="username" value="Nama Pengguna" class="!text-base !text-gray-500" />
        <x-underline-text-input wire:model.blur="username" name="username" />
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="location" value="Lokasi" class="!text-base !text-gray-500" />
        <x-underline-text-input wire:model.blur="location" name="location" />
        <x-input-error :messages="$errors->get('location')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="bio" value="Bio" class="!text-base !text-gray-500" />
        <x-underline-text-input wire:model.blur="bio" name="bio" />
        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="email" value="Email" class="!text-base !text-gray-500" />
        <x-underline-text-input wire:model.blur="email" name="email" type="email" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <x-primary-button class="mt-6" rounded>Simpan</x-primary-button>

    @script
        <script></script>
    @endscript
</form>
