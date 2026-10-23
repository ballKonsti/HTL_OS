<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Manager extends Component
{
    public string $picture_url = '';

    public int $picture_id = 0;

    public int $forward_id = 0;

    public int $right_id = 0;

    public int $left_id = 0;

    public int $back_id = 0;

    public $urls = [];

    public function save()
    {
        $this->urls[] = $this->picture_url;
    }

    public function render()
    {
        return view('components.admin.manager')->layout('layouts::admin');
    }
}
