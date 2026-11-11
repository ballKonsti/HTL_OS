<div class="w-full lg:w-64 border-b lg:border-b-0 lg:border-r pb-4 lg:pb-0 lg:pr-4">

    <h2 class="font-bold text-lg mb-4">
        Alle Bilder
    </h2>

    <ul class="space-y-2">
        @foreach ($images as $image)
            <x-admin.image-list :image="$image" />
        @endforeach
    </ul>



</div>
