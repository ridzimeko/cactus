<div {{ $attributes->merge(['class' => 'flex items-center gap-4 text-white mb-6']) }}>
    <img width="42px" height="auto" src="/img/cactus.png" alt="Cactus logo" />
    <div>
        {{ $slot }}
    </div>
</div>
