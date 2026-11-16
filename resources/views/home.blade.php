<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="app-background relative flex min-h-screen items-center justify-center overflow-hidden px-5 py-10 text-white antialiased">
        <main id="boot-screen" class="glass-panel relative w-full max-w-3xl overflow-hidden rounded-[2rem] p-7 sm:p-12">
            <div class="absolute inset-x-0 top-0 h-px bg-pink-200/70"></div>

            <div class="mb-12 flex items-center justify-between gap-4">
                <span class="text-xs font-semibold uppercase tracking-[0.3em] text-fuchsia-100">HTL OS</span>
                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs text-cyan-100/80">VIRTUAL TOUR</span>
            </div>

            <p class="mb-3 text-sm font-medium tracking-wide text-cyan-100/75">HTL Villach · Interaktiver Rundgang</p>
            <h1 class="max-w-2xl text-4xl font-semibold tracking-tight text-white sm:text-6xl">Tritt ein in eine neue Perspektive.</h1>
            <p class="mt-5 max-w-xl text-base leading-7 text-slate-300/80">Erkunde die HTL Villach Bild für Bild und entdecke, was hinter den Türen liegt.</p>

            <div class="mt-12">
                <div class="mb-3 flex items-center justify-between text-xs text-slate-300/70">
                    <span id="boot-text">Rundgang wird vorbereitet …</span>
                    <span>100%</span>
                </div>
                <div class="h-2 overflow-hidden rounded-full bg-white/10">
                    <div id="boot-progress" class="gradient-accent h-full w-full rounded-full shadow-[0_0_18px_rgba(230,163,184,0.25)]"></div>
                </div>
            </div>

            <button id="start-tour" type="button" class="gradient-accent mt-8 inline-flex min-h-12 items-center justify-center gap-3 rounded-xl px-6 py-3 text-sm font-semibold text-stone-950 shadow-lg shadow-pink-200/15 transition hover:brightness-105 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-100 focus-visible:ring-offset-2 focus-visible:ring-offset-stone-900">
                Rundgang starten <span aria-hidden="true">→</span>
            </button>
        </main>
    </body>
</html>
