<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class AdminInputs extends Component
{
    public $placeholder;
    public $model;

    public function __construct($placeholder, $model = 'imageSearch')
    {
        $this->placeholder = $placeholder;
        $this->model = $model;
    }

    public function render()
    {
        return view('components.admin.admin-inputs');
    }
}