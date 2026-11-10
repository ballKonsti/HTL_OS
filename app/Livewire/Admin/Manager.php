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
    public ?int $forward_id = null;

    #[Validate('nullable|integer|exists:nodes,id')]
    public ?int $back_id = null;

    #[Validate('nullable|integer|exists:nodes,id')]
    public ?int $right_id = null;

    #[Validate('nullable|integer|exists:nodes,id')]
    public ?int $left_id = null;

    #[Validate('required|alpha_dash|max:50|unique:nodes,name')]
    public string $name = '';

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
            'name' => $this->name,
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('admin-dashboard', [
            'nodes' => Node::orderBy('id')->get(),
            'previewUrl' => $this->photo?->isPreviewable() ? $this->photo->temporaryUrl() : null,

        ])->layout('layouts::admin');

    }
}
