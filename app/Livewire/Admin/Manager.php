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

    public string $picture_url = '';

    public int $picture_id = 0;

    public int $forward_id = 0;

    public int $right_id = 0;

    public int $left_id = 0;

    public int $back_id = 0;

    public $urls = [];

    public function save()
    {
        $this->validate();
        $this->photo->store(path: 'photos');
    }

    public function render()
    {
        return view('components.admin.manager')->layout('layouts::admin');
    }
}
