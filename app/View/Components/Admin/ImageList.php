<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class ImageList extends Component
{
    public $image;

    public function __construct($image)
    {
        $this->image = $image;
    }

    public function render()
    {
        return view('components.admin.image-list');
    }
}