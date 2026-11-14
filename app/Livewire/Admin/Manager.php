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

    #[Validate('nullable|exists:nodes,name')]
    public ?string $forward_id = null;

    #[Validate('nullable|exists:nodes,name')]
    public ?string $back_id = null;

    #[Validate('nullable|exists:nodes,name')]
    public ?string $right_id = null;

    #[Validate('nullable|exists:nodes,name')]
    public ?string $left_id = null;

    #[Validate('required|alpha_dash|max:50|unique:nodes,name')]
    public string $name = '';

    public ?int $editingId = null;

    public ?string $existingPicUrl = null;

    public function save()
    {
        $this->validate();
        $path = $this->photo->store('pictures', 'public');

        Node::create([
            'pic_url' => $path,
            'forward_id' => $this->nodeIdFor($this->forward_id),
            'back_id' => $this->nodeIdFor($this->back_id),
            'left_id' => $this->nodeIdFor($this->left_id),
            'right_id' => $this->nodeIdFor($this->right_id),
            'name' => $this->name,
        ]);

        $this->reset();
    }

    public function edit(int $id): void
    {
        $node = Node::findOrFail($id);

        $this->editingId = $node->id;
        $this->existingPicUrl = $node->pic_url;
        $this->name = $node->name;
        $this->forward_id = $node->forward?->name;
        $this->back_id = $node->back?->name;
        $this->left_id = $node->left?->name;
        $this->right_id = $node->right?->name;

        $this->reset('photo');
        $this->resetValidation();
    }

    private function nodeIdFor(?string $name): ?int
    {
        if (blank($name)) {
            return null;
        }

        return Node::where('name', $name)->value('id');
    }

    public function loadNext()
    {
        $currentId = $this->editingId ?? 0;
        $nextId = $currentId + 1;

        $nextNode = Node::find($nextId);

        if ($nextNode) {
            $this->edit($nextNode->id);
        } else {
            $this->reset();
        }
    }

    public function render()
    {
        return view('admin-dashboard', [
            'nodes' => Node::orderBy('id')->get(),
            'previewUrl' => $this->photo?->isPreviewable() ? $this->photo->temporaryUrl() : ($this->existingPicUrl ? asset('storage/'.$this->existingPicUrl) : null),

        ])->layout('layouts::admin');

    }
}
