<input type="file" id="image-upload" wire:model="photo" accept="image/*" class="sr-only">

<label for="image-upload" class="group glass-panel-soft flex h-[min(45dvh,34rem)] min-h-48 w-full cursor-pointer items-center justify-center rounded-2xl border-dashed p-3 text-center transition hover:border-fuchsia-300/45 focus-within:ring-2 focus-within:ring-fuchsia-300 sm:h-[min(55dvh,34rem)]">
    <div class="flex h-full w-full flex-col items-center justify-center overflow-hidden rounded-xl">

        @if ($previewUrl)
            <img src="{{ $previewUrl }}" alt="Vorschau" class="h-full w-full rounded-xl object-contain">
        @else
            <span class="gradient-accent mb-3 flex size-12 items-center justify-center rounded-2xl text-2xl text-slate-950 shadow-lg shadow-fuchsia-500/15 transition group-hover:brightness-110" aria-hidden="true">+</span>
            <span class="text-sm font-medium text-zinc-200">Bild auswählen</span>
            <span class="mt-1 text-xs text-zinc-500">JPG, PNG oder WebP</span>
        @endif
        @error('photo')
            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>
</label>
