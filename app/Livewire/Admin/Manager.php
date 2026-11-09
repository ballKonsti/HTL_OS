<?php

namespace App\Livewire\Admin;

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

    public function save()
    {
        $this->validate();
        dd($this->photo, $this->forward_id, $this->back_id, $this->left_id, $this->right_id);
        $this->photo->store('pictures', 'public');

    }

    public function render()
    {
        return view('admin-dashboard')->layout('layouts::admin');
    }
}
