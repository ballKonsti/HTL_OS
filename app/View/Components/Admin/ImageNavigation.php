<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ImageNavigation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Collection $nodes, public ?string $previewUrl = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.image-navigation');
    }
}
