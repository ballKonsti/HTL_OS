<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="m-0 min-h-screen overflow-hidden bg-black antialiased">

    <div id="boot-screen"
         class="relative flex h-screen w-full items-center justify-center overflow-hidden bg-black">

        <!-- Hintergrundvideo -->
        <video
            autoplay
            muted
            loop
            playsinline
            src="{{ asset('videos/drohne.mp4') }}"
            class="absolute inset-0 h-full w-full object-cover">
        </video>

        <!-- Dunkle Ebene für bessere Lesbarkeit -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- HTL_OS Logo und Schriftzug -->
        <div class="relative z-10 flex flex-col items-center text-center">

            <p class="mb-4 text-sm font-semibold tracking-[0.4em] text-yellow-400">
                HTL VILLACH
            </p>

            <h1 class="text-6xl font-black tracking-widest text-yellow-400 md:text-8xl">
                HTL_OS
            </h1>

            <p class="mt-4 text-sm tracking-[0.3em] text-white">
                VIRTUAL TOUR EXPERIENCE
            </p>

        
        <button
            type="button"
            id="start-tour"
            class="mt-12 rounded-md border-2 border-yellow-400 bg-yellow-400
                px-8 py-4 font-bold uppercase tracking-widest text-black
                transition duration-300
                hover:bg-transparent hover:text-yellow-400
                focus:outline-none focus:ring-4 focus:ring-yellow-400/50">

            Rundgang starten
        </button>
        </div>
    </div>

    
    <video
        id="dive-video"
        class="fixed inset-0 z-20 hidden h-full w-full bg-black object-cover"
        muted
        playsinline
        preload="auto"
        src="{{ asset('videos/drohne-dive.mp4') }}">
    </video>

    <script>
    const startButton = document.getElementById('start-tour');
    const bootScreen = document.getElementById('boot-screen');
    const diveVideo = document.getElementById('dive-video');

    startButton.addEventListener('click', () => {

        // Startbildschirm ausblenden
        bootScreen.classList.add('hidden');

        // Zweites Video anzeigen
        diveVideo.classList.remove('hidden');

        // Video starten
        diveVideo.play().catch(error => {
            console.error('Video konnte nicht gestartet werden:', error);
        });

    });
</script>

</body>
</html>
