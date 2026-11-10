<div>
    <input type="number" placeholder="{{ $placeholder }}" wire:model="{{ $model }}"
        class="w-40 p-2 border border-gray-300 rounded-md text-center">
    @error($model)
        <p class="text-red-600 text-xs mt-1 w-40">{{ $message }}</p>
    @enderror
</div>
