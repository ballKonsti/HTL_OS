<x-layouts::app :title="__('Dashboard')">
    <div class="flex min-h-[60dvh] items-center justify-center">
        <section class="max-w-lg text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-pink-300">HTL OS</p>
            <h1 class="mt-3 text-3xl font-semibold text-zinc-950 dark:text-white">Willkommen im Node-Editor</h1>
            <p class="mt-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">Verwalte Fotos und Verbindungen im Admin-Bereich oder starte den virtuellen Rundgang.</p>
            <div class="mt-7 flex flex-wrap justify-center gap-3">
                <a href="{{ route('admin') }}" class="rounded-xl bg-zinc-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-950 dark:hover:bg-zinc-200">Admin öffnen</a>
                <a href="{{ route('Rundgang') }}" class="rounded-xl border border-zinc-300 px-4 py-3 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-white dark:hover:bg-zinc-800">Rundgang öffnen</a>
            </div>
        </section>
    </div>
</x-layouts::app>
