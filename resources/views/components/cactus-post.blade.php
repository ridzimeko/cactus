@props([
    'id',
    'type',
    'name',
    'text' => null,
    'username' => null,
    'date' => null,
    'image' => null,
    'repliesCount' => 0,
    'avatar' => null,
    'size' => 'medium',
])

@php
    $fullTime = null;

    $waktu_sekarang = time(); // Waktu saat ini dalam detik

    $selisih_detik = $waktu_sekarang - strtotime($date);
    $selisih_hari = floor($selisih_detik / (60 * 60 * 24));
    $selisih_jam = floor($selisih_detik / (60 * 60));
    $selisih_menit = floor($selisih_detik / 60);

    if ($selisih_hari > 0) {
        $fullTime = $selisih_hari . ' hari lalu';
    } elseif ($selisih_jam > 0) {
        $fullTime = $selisih_jam . ' jam lalu';
    } else {
        $fullTime = $selisih_menit . ' menit lalu';
    }
@endphp

<div {{ $attributes }}>
    <article class="group flex gap-6">
        <div class="flex-shrink-0">
            <a class="text-base hover:underline" href="{{ route('profile.view', $username) }}">
                <x-user-avatar :avatar="$avatar" class="flex-shrink-0" :size="$size" />
            </a>
        </div>

        <div class="w-full text-white">
            <header class="flex items-center gap-4">
                <a class="text-lg text-gray-200 hover:underline"
                    href="{{ route('profile.view', [$username]) }}">{{ $name }}</a>
                <span class="text-gray-400">{{ $fullTime }}</span>
                @if ($username === Auth::user()->username)
                    <div class="opacity-0 transition-all group-hover:opacity-100">
                        <form action="/{{ $type }}/{{ $id }}" method="post">
                            @csrf
                            @method('delete')

                            <button title="Hapus post">
                                @svg('heroicon-s-trash', ['class' => 'size-5'])
                            </button>
                        </form>
                    </div>
                @endif
            </header>
            <p class="break-all">{{ $text }}</p>
            @if ($image)
                <div class="my-2 h-[320px] w-full rounded-sm bg-gray-800">
                    <a href="{{ $image }}" target="_blank" rel="noopener noreferrer">
                        <img src="{{ $image }}" class="h-full w-full object-contain">
                    </a>
                </div>
            @endif

            @if ($type === 'question')
                <a href="{{ route('question.view', ['id' => $id]) }}">{{ $repliesCount }}
                    jawaban</a>
            @endif
        </div>
    </article>
</div>
