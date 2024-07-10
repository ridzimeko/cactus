@props([
    'text' => null,
    'name' => null,
    'username' => null,
    'date' => null,
    'avatar' => null,
    'questionId' => null,
])

<div {{ $attributes->merge(['class' => 'flex gap-6 px-4 py-2 border-b border-b-gray-400']) }}>
    <div class="flex-shrink-0">
        <a class="text-base hover:underline" href="{{ route('profile.view', $username) }}">
            <x-user-avatar :avatar="$avatar" class="flex-shrink-0" />
        </a>
    </div>

    <div class="text-white">
        <div class="flex items-center">
            <p class="text-base">
                <a href="{{ route('profile.view', [$username]) }}"
                    class="text-gray-200 hover:underline">{{ $name }}</a>
                mengomentari postingan anda
            </p>
        </div>
        <a class="text-base hover:underline" href="{{ route('question.view', [$questionId]) }}">{{ $text }}</a>
    </div>
</div>
