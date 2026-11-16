<header class="glass-panel relative flex shrink-0 flex-col gap-3 overflow-hidden rounded-2xl p-4 sm:flex-row sm:items-end sm:justify-between sm:gap-5 sm:p-5">
    <div class="space-y-1">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-pink-200">HTL OS <span class="text-stone-300/50">/</span> Admin</p>
        <h1 class="text-2xl font-semibold tracking-tight text-white sm:text-3xl">Node editor</h1>
        <p class="text-sm text-stone-300/80">Bilder und Verbindungen für den Rundgang verwalten.</p>
    </div>

    <div class="w-full sm:max-w-xs">
        <label for="node-name" class="mb-2 block text-sm font-medium text-stone-200">Node-Name</label>
        <input id="node-name" type="text" wire:model="name" placeholder="z. B. ugg_1"
            class="w-full rounded-xl border border-pink-100/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-stone-400/60 focus:border-pink-200/50 focus:outline-none focus:ring-2 focus:ring-pink-200/15">
    @error('name')
            <p class="mt-2 text-xs text-rose-200">{{ $message }}</p>
    @enderror
    </div>
</header>
