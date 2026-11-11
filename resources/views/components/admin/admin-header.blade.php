<div>
    <input type="text" wire:model="name" placeholder="Name, z.B. ugg_1"
        class="w-48 p-2 border border-gray-300 rounded-md">
    @error('name')
        <p class="text-red-600 text-xs mt-1 w-48">{{ $message }}</p>
    @enderror
</div>
