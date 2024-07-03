@props(['avatar', 'name', 'username'])

<a href="/user/{{ $username }}" class="flex items-center gap-4 rounded hover:bg-slate-600 p-2">
    <x-user-avatar :avatar="$avatar" class="!size-12" />
    <div>
        <p class="text-lg text-white">{{ $name }}</p>
        <p class="text-gray-400 text-base">{{ $username }}</p>
    </div>
</a>