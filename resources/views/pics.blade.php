<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="relative h-dvh w-full overflow-hidden bg-stone-950 text-white antialiased">
    <img id="tour-image" alt="Virtueller Rundgang" class="block h-dvh w-full object-contain" aria-busy="true">

    <div class="pointer-events-none fixed inset-0 bg-[radial-gradient(circle_at_50%_100%,rgb(0_0_0_/_45%),transparent_42%)]" aria-hidden="true"></div>

    <div id="tour-loading" class="pointer-events-none fixed inset-0 z-20 grid place-items-center bg-stone-950/55 backdrop-blur-sm">
        <div class="glass-panel rounded-2xl px-5 py-4 text-center shadow-2xl">
            <div class="mx-auto mb-3 size-7 animate-spin rounded-full border-2 border-pink-100/25 border-t-pink-200" aria-hidden="true"></div>
            <p class="text-sm font-medium text-white">Rundgang wird geladen …</p>
        </div>
    </div>

    <p id="tour-status" class="pointer-events-none fixed inset-x-4 bottom-24 z-30 text-center text-sm text-white" aria-live="polite"></p>

    <x-tour.hud />
    <x-tour.enter-prompt />
    <x-tour.room-view />
</body>
</html>
