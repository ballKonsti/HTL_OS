<?php

namespace App\Livewire\Admin;

use App\Models\Node;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Manager extends Component
{
    use WithFileUploads;

    public $photo;

    public ?string $forward_id = null;

    public ?string $back_id = null;

    public ?string $right_id = null;

    public ?string $left_id = null;

    public string $name = '';

    public ?int $editingId = null;

    public ?string $existingPicUrl = null;

    public bool $start = false;

    protected function rules(): array
    {
        return [
            'photo' => [
                Rule::requiredIf($this->editingId === null),
                'nullable',
                'image',
                'max:100240',
            ],
            'forward_id' => ['nullable', 'exists:nodes,name'],
            'back_id' => ['nullable', 'exists:nodes,name'],
            'right_id' => ['nullable', 'exists:nodes,name'],
            'left_id' => ['nullable', 'exists:nodes,name'],
            'name' => [
                'required',
                'alpha_dash',
                'max:50',
                Rule::unique('nodes', 'name')->ignore($this->editingId),

            ],
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $node = $this->editingId ? Node::findOrFail($this->editingId) : new Node;

        if ($this->photo) {
            $node->pic_url = $this->photo->store('pictures', 'public');
        }

        $node->forward_id = $this->nodeIdFor($this->forward_id);
        $node->back_id = $this->nodeIdFor($this->back_id);
        $node->left_id = $this->nodeIdFor($this->left_id);
        $node->right_id = $this->nodeIdFor($this->right_id);
        $node->name = $validated['name'];
        $this->start = (bool) $node->start;
        $node->save();

        $this->reset();
        $this->resetValidation();
    }

    public function edit(int $id): void
    {
        $node = Node::findOrFail($id);
        $this->start = (bool) $node->start;
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

    public function saveStart(): void
    {
        if ($this->editingId === null) {
            return;
        }

        $node = Node::findOrFail($this->editingId);
        $isCurrentlyStart = (bool) $node->start;

        DB::transaction(function () use ($node, $isCurrentlyStart): void {
            if ($isCurrentlyStart) {
                $node->start = false;
                $node->save();

                return;
            }

            Node::query()->where('start', true)->update(['start' => false]);

            $node->start = true;
            $node->save();
        });

        $this->start = ! $isCurrentlyStart;
    }

    public function render()
    {
        return view('admin-dashboard', [
            'nodes' => Node::orderBy('id')->get(),
            'previewUrl' => $this->photo?->isPreviewable() ? $this->photo->temporaryUrl() : ($this->existingPicUrl ? asset('storage/'.$this->existingPicUrl) : null),
            'start' => $this->start,
        ])->layout('layouts::admin');

    }
}
