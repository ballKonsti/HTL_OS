<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Node-Graph – HTL OS</title>
    @vite(['resources/css/app.css', 'resources/js/graph-viewer.js'])
</head>
<body class="app-background h-dvh overflow-hidden p-3 text-stone-100 antialiased sm:p-4">
    <main id="node-graph" class="mx-auto flex h-full max-w-[1800px] flex-col gap-3" data-api-url="{{ route('api.nodes.index') }}" data-admin-url="{{ route('admin') }}">
        <header class="glass-panel flex shrink-0 flex-col gap-4 rounded-2xl p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-pink-200">HTL OS <span class="text-stone-300/50">/</span> Node-Graph</p>
                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-white sm:text-3xl">Graph-Ansicht</h1>
                <p class="mt-1 text-sm text-stone-300/80">Ziehe Nodes, zoome mit dem Mausrad und prüfe alle Verbindungen.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin') }}" class="glass-panel-soft inline-flex min-h-11 items-center justify-center rounded-xl px-4 py-2.5 text-sm font-semibold text-stone-100 transition hover:border-pink-200/25 hover:text-white">Editor öffnen</a>
                <a href="{{ route('Rundgang') }}" class="gradient-accent inline-flex min-h-11 items-center justify-center rounded-xl px-4 py-2.5 text-sm font-semibold text-stone-950 transition hover:brightness-105">Rundgang testen</a>
            </div>
        </header>

        <section class="grid min-h-0 flex-1 gap-3 lg:grid-cols-[minmax(0,1fr)_19rem]">
            <div class="glass-panel relative min-h-0 overflow-hidden rounded-2xl">
                <div class="absolute inset-x-3 top-3 z-20 flex flex-wrap items-center gap-2 sm:inset-x-4">
                    <label class="glass-panel-soft flex min-h-10 flex-1 items-center gap-2 rounded-xl px-3 sm:max-w-xs">
                        <span aria-hidden="true" class="text-pink-100">⌕</span>
                        <input id="graph-search" type="search" placeholder="Node suchen …" class="min-w-0 flex-1 bg-transparent text-sm text-white outline-none placeholder:text-stone-400">
                    </label>
                    <button id="graph-fit" type="button" class="glass-panel-soft min-h-10 rounded-xl px-3 text-sm font-semibold text-stone-100 transition hover:border-pink-200/25">Ansicht zentrieren</button>
                    <button id="graph-reset" type="button" class="glass-panel-soft min-h-10 rounded-xl px-3 text-sm font-semibold text-stone-100 transition hover:border-pink-200/25">Layout zurücksetzen</button>
                </div>

                <div id="graph-viewport" class="graph-viewport h-full min-h-[34rem] touch-none" aria-label="Interaktive Node-Graph-Ansicht">
                    <div id="graph-canvas" class="graph-canvas">
                        <svg id="graph-edges" class="pointer-events-none absolute inset-0 h-full w-full overflow-visible" aria-hidden="true">
                            <defs>
                                <marker id="graph-arrow" markerWidth="8" markerHeight="8" refX="7" refY="4" orient="auto"><path d="M 0 0 L 8 4 L 0 8 z" fill="currentColor" /></marker>
                            </defs>
                        </svg>
                        <div id="graph-nodes"></div>
                    </div>
                </div>

                <p id="graph-status" class="pointer-events-none absolute bottom-3 left-4 z-20 text-xs text-stone-300/80" aria-live="polite">Graph wird geladen …</p>
            </div>

            <aside class="glass-panel flex min-h-0 flex-col rounded-2xl p-4 sm:p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-pink-200">Inspektor</p>
                <h2 id="graph-node-name" class="mt-2 text-xl font-semibold text-white">Kein Node ausgewählt</h2>
                <p id="graph-node-meta" class="mt-1 text-sm text-stone-400">Klicke einen Node an, um seine Verbindungen zu sehen.</p>

                <img id="graph-node-image" alt="" class="mt-5 hidden aspect-video w-full rounded-xl object-cover ring-1 ring-white/10">

                <dl class="mt-6 grid gap-3 text-sm">
                    <div class="glass-panel-soft rounded-xl p-3"><dt class="text-xs uppercase tracking-wide text-stone-400">Vorwärts</dt><dd id="graph-forward" class="mt-1 font-medium text-white">—</dd></div>
                    <div class="glass-panel-soft rounded-xl p-3"><dt class="text-xs uppercase tracking-wide text-stone-400">Zurück</dt><dd id="graph-back" class="mt-1 font-medium text-white">—</dd></div>
                    <div class="glass-panel-soft rounded-xl p-3"><dt class="text-xs uppercase tracking-wide text-stone-400">Links / Rechts</dt><dd id="graph-sides" class="mt-1 font-medium text-white">—</dd></div>
                </dl>

                <div class="mt-auto border-t border-pink-100/10 pt-4 text-xs leading-5 text-stone-400">Ziehe den freien Bereich zum Verschieben. Mit dem Mausrad zoomst du. Die Positionen werden nur in diesem Browser gespeichert.</div>
            </aside>
        </section>
    </main>
</body>
</html>
