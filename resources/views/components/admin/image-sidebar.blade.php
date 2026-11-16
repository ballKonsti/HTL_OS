<section class="glass-panel flex max-h-[55dvh] min-h-0 flex-col overflow-hidden rounded-2xl p-3 sm:p-4 lg:max-h-[34rem]">
    <div class="mb-4 flex items-center justify-between gap-3">
        <h2 class="text-sm font-semibold text-white">Alle Bilder</h2>
        <span class="rounded-full border border-pink-100/10 bg-white/5 px-2.5 py-1 text-xs text-stone-200/80">{{ $images->count() }}</span>
    </div>

    <ul class="admin-scrollbar grid max-h-[calc(55dvh-6rem)] min-h-0 flex-1 auto-rows-max grid-cols-1 gap-2 overflow-y-auto overscroll-contain pr-2 sm:grid-cols-2 lg:max-h-[calc(34rem-6rem)] lg:grid-cols-1">
        @foreach ($images as $image)
            <x-admin.image-list :image="$image" />
        @endforeach
    </ul>
</section>
