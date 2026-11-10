<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class ImageSidebar extends Component
{
    public $images;

    public function __construct($images = [])
    {
        $this->images = $images;
    }

    public function render()
    {
        return view('components.admin.image-sidebar');
    }
}