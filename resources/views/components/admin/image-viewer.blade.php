<input type="file" id="image-upload" wire:model="photo" accept="iamge/*" class="hidden">

<label for="image-upload" class="">


    <div
        class="border-2 border-gray-400 rounded-lg
            w-full aspect-square max-w-80
            flex items-center justify-center
            bg-gray-50 mx-auto">

        @if ($previewUrl)
            <img src="{{ $previewUrl }}" alt="Vorschau" class="w-full h-full object-cover rounded-lg">
        @else
            <label>
                Datein auswählen
            </label>
        @endif
        @error('photo')
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>
</label>
</input>
