<div class="grid w-full gap-6 xl:grid-cols-[minmax(0,1fr)_19rem] xl:items-stretch">
    <section class="min-w-0 p-1 sm:p-2">
        <div class="mb-4 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-sm font-semibold text-white">Bildvorschau</h2>
                <p class="mt-1 text-xs text-stone-400">Klicke auf das Bild, um es zu ersetzen.</p>
            </div>
            <span class="rounded-full border border-pink-100/10 bg-white/5 px-2.5 py-1 text-xs text-stone-200/80">Vorschau</span>
        </div>

        <div class="glass-panel-soft mx-auto w-full max-w-none overflow-hidden rounded-2xl">
            <x-admin.image-viewer :preview-url="$previewUrl" />
        </div>
    </section>

    <aside class="min-w-0 border-t border-pink-100/10 pt-5 xl:border-l xl:border-t-0 xl:pl-6 xl:pt-1">
        <div class="mb-5">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-pink-200">Node-Graph</p>
            <h2 class="mt-1 text-lg font-semibold text-white">Verbindungen</h2>
            <p class="mt-1 text-xs leading-5 text-stone-400">Wähle, welcher Node in jede Richtung folgt.</p>
        </div>

        <div class="grid grid-cols-2 gap-3 xl:grid-cols-1 xl:gap-4">
            <x-admin.admin-inputs :nodes="$nodes" placeholder="Vorwärts" model="forward_id" />
            <x-admin.admin-inputs :nodes="$nodes" placeholder="Zurück" model="back_id" />
            <x-admin.admin-inputs :nodes="$nodes" placeholder="Links" model="left_id" />
            <x-admin.admin-inputs :nodes="$nodes" placeholder="Rechts" model="right_id" />
        </div>
    </aside>
</div>
