<?php

namespace App\Livewire\Admin;

use App\Models\Node;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Manager extends Component
{
    use WithFileUploads;

    #[Validate('required|image|max:100240')]
    public $photo;

    #[Validate('nullable|integer|exists:nodes,id')]
    public ?string $forward_id = null;

    #[Validate('nullable|integer|exists:nodes,id')]
    public ?string $back_id = null;

    #[Validate('nullable|integer|exists:nodes,id')]
    public ?string $right_id = null;

    #[Validate('nullable|integer|exists:nodes,id')]
    public ?string $left_id = null;

    public function save()
    {
        $this->validate();
        $path = $this->photo->store('pictures', 'public');

        Node::create([
            'pic_url' => $path,
            'forward_id' => $this->forward_id,
            'back_id' => $this->back_id,
            'left_id' => $this->left_id,
            'right_id' => $this->right_id,
        ]);

        $this->reset();
    }

    private function nodeIdFor(?string $name): ?int
    {
        if (blank($name)) {
            return null;
        }

        return Node::where('name', $name)->value('id');
    }

    public function render()
    {
        return view('admin-dashboard', [
            'nodes' => Node::orderBy('id')->get(),
            'previewUrl' => $this->photo?->isPreviewable() ? $this->photo->temporaryUrl() : null,

        ])->layout('layouts::admin');

    }
}
