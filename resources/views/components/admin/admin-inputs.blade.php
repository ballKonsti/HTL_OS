<div>
    <input type="text" list="nodes-{{ $model }}" placeholder="{{ $placeholder }}"
        wire:model="{{ $model }}" class="w-full max-w-48 rounded-xl border border-pink-100/10 bg-white/[0.035] px-3 py-3 text-center text-sm text-white placeholder:text-stone-400/60 focus:border-pink-200/50 focus:outline-none focus:ring-2 focus:ring-pink-200/15">
    <datalist id="nodes-{{ $model }}">
        @foreach ($nodes as $node)
            <option value="{{ $node->name }}"></option>
        @endforeach
    </datalist>
    @error($model)
        <p class="mt-2 w-full max-w-48 text-xs text-rose-300">{{ $message }}</p>
    @enderror
</div>
