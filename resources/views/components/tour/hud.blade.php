<div class="pointer-events-none fixed inset-0 z-10 p-4 sm:p-6">
    <div class="glass-panel pointer-events-auto flex w-fit items-center gap-3 rounded-2xl px-4 py-3">
        <span class="size-2 rounded-full bg-pink-200 shadow-[0_0_16px_rgb(251_207_232)]" aria-hidden="true"></span>
        <div>
            <p class="text-[0.65rem] font-semibold uppercase tracking-[0.2em] text-pink-100/80">HTL OS</p>
            <p id="hud-location" class="text-sm font-medium text-white">Rundgang wird geladen</p>
        </div>
    </div>

    <p id="hud-hint" class="glass-panel pointer-events-auto absolute bottom-5 left-1/2 hidden -translate-x-1/2 rounded-full px-4 py-2 text-center text-xs text-stone-200 sm:block">
        Mausrad, Pfeiltasten oder W/A/S/D verwenden
    </p>

    <button type="button" data-arrow="left" data-tour-direction="left" aria-label="Nach links abbiegen" hidden class="glass-panel pointer-events-auto absolute left-4 top-1/2 inline-flex -translate-y-1/2 items-center gap-2 rounded-full px-4 py-3 text-sm font-semibold text-white transition hover:border-pink-100/50 hover:bg-pink-100/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-100 sm:left-7"><span aria-hidden="true">←</span><span>Links</span></button>
    <button type="button" data-arrow="back" data-tour-direction="back" aria-label="Zurückgehen" hidden class="glass-panel pointer-events-auto absolute bottom-5 left-4 inline-flex items-center gap-2 rounded-full px-4 py-3 text-sm font-semibold text-white transition hover:border-pink-100/50 hover:bg-pink-100/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-100 sm:left-7"><span aria-hidden="true">↓</span><span>Zurück</span></button>
    <button type="button" data-arrow="forward" data-tour-direction="forward" aria-label="Geradeaus weitergehen" hidden class="glass-panel pointer-events-auto absolute bottom-5 left-1/2 inline-flex -translate-x-1/2 items-center gap-2 rounded-full px-4 py-3 text-sm font-semibold text-white transition hover:border-pink-100/50 hover:bg-pink-100/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-100"><span aria-hidden="true">↑</span><span>Geradeaus</span></button>
    <button type="button" data-arrow="right" data-tour-direction="right" aria-label="Nach rechts abbiegen" hidden class="glass-panel pointer-events-auto absolute right-4 top-1/2 inline-flex -translate-y-1/2 items-center gap-2 rounded-full px-4 py-3 text-sm font-semibold text-white transition hover:border-pink-100/50 hover:bg-pink-100/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-100 sm:right-7"><span>Rechts</span><span aria-hidden="true">→</span></button>
</div>
