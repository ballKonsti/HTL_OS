<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="h-dvh w-full overflow-hidden relative z-20 ">
    <img id="tour-image" alt="virtueller rundgang" class="block h-dvh w-full object-cover">

    <button type="button" data-tour-direction="left" aria-label="Nach links abbiegen" hidden
        class="fixed left-4 top-1/2 z-10 inline-flex -translate-y-1/2 items-center rounded-full border border-white/20 bg-black/60 px-4 py-3 text-sm font-medium text-white shadow-lg backdrop-blur transition hover:bg-black/75 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white sm:left-8">
        ← Links
    </button>
    <button type="button" data-tour-direction="forward" aria-label="Geradeaus weitergehen" hidden
        class="fixed bottom-6 left-1/2 z-10 inline-flex -translate-x-1/2 items-center rounded-full border border-white/20 bg-black/60 px-4 py-3 text-sm font-medium text-white shadow-lg backdrop-blur transition hover:bg-black/75 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white">
        ↑ Geradeaus
    </button>
    <button type="button" data-tour-direction="right" aria-label="Nach rechts abbiegen" hidden
        class="fixed right-4 top-1/2 z-10 inline-flex -translate-y-1/2 items-center rounded-full border border-white/20 bg-black/60 px-4 py-3 text-sm font-medium text-white shadow-lg backdrop-blur transition hover:bg-black/75 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white sm:right-8">
        Rechts →
    </button>



</body>

</html>
