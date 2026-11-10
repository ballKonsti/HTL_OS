<?php

namespace App\View\Components\Admin;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class AdminInputs extends Component
{
    public function __construct(public string $placeholder, public Collection $nodes, public string $model = 'imageSearch') {}

    public function render()
    {
        return view('components.admin.admin-inputs');
    }
}
