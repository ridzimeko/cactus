@php
    $user = Auth::user();
@endphp

<aside
    {{ $attributes->merge(['class' => 'sticky top-0 z-30 max-h-screen w-[280px] border-s-2 border-l-gray-800 bg-gray-950 hidden lg:block']) }}>
    <div class="m-4 rounded-lg border border-gray-600 p-8 text-center text-white">
        <x-user-avatar :avatar="$user->profile_img" class="mx-auto mb-2" />

        <h2 class="overflow-hidden overflow-ellipsis whitespace-nowrap text-lg">{{ $user->name ?? '' }}</h2>
        <h3 class="mt-2 flex items-center justify-center gap-1">
            @svg('heroicon-c-map-pin', ['class' => 'size-6'])
            {{ $user->location ?? '' }}
        </h3>
    </div>
</aside>
