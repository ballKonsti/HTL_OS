<div class="mt-8">

    <h2 class="font-bold mb-4">
        Bilder hinzufügen:
    </h2>

    <input type="file" id="image-upload" wire:model="photo" accept="image/*" class="hidden">
    <label for="image-upload"
        class="inline-block bg-yellow-400 hover:bg-yellow-700 text-black px-5 py-2 rounded-md cursor-pointer">
        Dateien auswählen
    </label>
    @error('photo')
        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>
