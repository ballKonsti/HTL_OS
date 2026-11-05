<div class="w-1/4 border-r pr-4">

    <h2 class="font-bold mb-4">Alle Bilder</h2>

    <ul class="space-y-2">

        @foreach($images as $image)

            <x-admin.image-list :image="$image" />

        @endforeach

    </ul>

    <p class="mt-6 mb-2">Bilder hinzufügen:</p>

    <input type="file" accept="image/*" multiple>

</div>