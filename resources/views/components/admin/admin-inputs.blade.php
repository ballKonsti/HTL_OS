<div>
    <input type="text" list="nodes-{{ $model }}" placeholder="{{ $placeholder }}"
        wire:model="{{ $model }}" class="w-40 p-2 border border-gray-300 rounded-md text-center">
    <datalist id="nodes-{{ $model }}">
        @foreach ($nodes as $node)
            <option value="{{ $node->name }}"></option>
        @endforeach
    </datalist>
    @error($model)
        <p class="text-red-600 text-xs mt-1 w-40">{{ $message }}</p>
    @enderror
</div>
