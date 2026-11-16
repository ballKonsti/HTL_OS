<li wire:key="node-{{ $image->id }}">
    <button type="button" wire:click="edit({{ $image->id }})"
        class="glass-panel-soft group flex w-full items-center gap-3 rounded-xl p-2.5 text-left text-sm text-stone-200/90 transition hover:border-pink-200/35 hover:bg-pink-100/5 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-200">

        <img src="{{ asset('storage/' . $image->pic_url) }}" alt="Node {{ $image->id }}"
            class="size-12 shrink-0 rounded-lg object-cover ring-1 ring-white/15 transition group-hover:ring-pink-100/40">
        <span class="min-w-0 truncate font-medium">{{ $image->name }}</span>
        <span class="ml-auto text-stone-500 transition group-hover:text-pink-100" aria-hidden="true">→</span>
    </button>
</li>
