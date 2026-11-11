<li>
    <button type="button" wire:click="edit({{ $image->id }})"
        class="w-full text-left border rounded p-2 bg-yellow-400 hover:bg-yellow-700">

        <img src="{{ asset('storage/' . $image->pic_url) }}" alt="Node {{ $image->id }}"
            class="w-12 h-12 object-cover rounded inline-block mr-2">
        {{ $image->name }}
    </button>
</li>
