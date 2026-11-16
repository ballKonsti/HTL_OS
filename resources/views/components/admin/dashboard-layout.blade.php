<main class="mx-auto flex h-full max-h-full w-full max-w-screen-2xl flex-col gap-3 overflow-hidden">

    <x-admin.admin-header />

    <div class="grid min-h-0 flex-1 items-start grid-rows-[auto_minmax(0,1fr)] gap-3 overflow-hidden lg:grid-cols-[16rem_minmax(0,1fr)] lg:grid-rows-1">

        <aside class="min-w-0">
            <x-admin.image-sidebar :images="$nodes" />
        </aside>

        <section class="glass-panel admin-scrollbar min-h-0 min-w-0 overflow-y-auto overscroll-contain rounded-2xl p-3 sm:p-5">
            <x-admin.image-navigation :nodes="$nodes" :previewUrl="$previewUrl" />
        </section>

    </div>

    <div class="glass-panel flex shrink-0 flex-col gap-3 rounded-2xl p-3 sm:flex-row sm:items-center sm:justify-between sm:p-4">
        <x-admin.admin-actions />
        <x-admin.admin-button
            :text="$start ? 'Startbild aktiv' : 'Als Startbild festlegen'"
            action="saveStart"
            :color="$start ? 'gradient-accent text-stone-950 shadow-lg shadow-pink-200/15 hover:brightness-105' : 'glass-panel-soft text-stone-100 hover:border-pink-200/25 hover:text-white'"
        />
    </div>

</main>
