<dialog id="room-view" class="m-auto w-[min(42rem,calc(100%-2rem))] rounded-3xl border border-pink-100/20 bg-stone-950 p-0 text-white shadow-2xl backdrop:bg-black/70">
    <article class="glass-panel max-h-[min(48rem,calc(100dvh-2rem))] overflow-y-auto rounded-3xl p-5 sm:p-7">
        <div class="flex items-start justify-between gap-4">
            <div><p class="text-xs font-semibold uppercase tracking-[0.2em] text-pink-200">Raum</p><h2 id="room-name" class="mt-1 text-2xl font-semibold tracking-tight text-white">Raum</h2></div>
            <button id="room-close" type="button" class="rounded-full border border-white/15 px-3 py-2 text-sm text-stone-200 transition hover:border-pink-100/50 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-100">Schließen</button>
        </div>
        <div class="mt-6 flex items-center gap-4"><img id="room-teacher-image" alt="Lehrperson" class="size-16 rounded-2xl object-cover" hidden><div><p class="text-xs uppercase tracking-wide text-stone-400">Lehrperson</p><p id="room-teacher-name" class="mt-1 font-medium text-white">Information folgt</p></div></div>
        <p id="room-dialogue" class="mt-6 text-sm leading-7 text-stone-200"></p>
        <div id="room-gallery" class="mt-6 grid gap-3 sm:grid-cols-2"></div>
    </article>
</dialog>
