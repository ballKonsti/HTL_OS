<div
    class="border-2 border-gray-400 rounded-lg
            w-full aspect-square max-w-80
            flex items-center justify-center
            bg-gray-50 mx-auto">

    @if ($previewUrl)
        <img src="{{ $previewUrl }}" alt="Vorschau" class="w-full h-full object-cover rounded-lg">
    @else
        <p class="text-gray-500 text-sm sm:text-base">Aktuelles Bild</p>
    @endif

</div>
