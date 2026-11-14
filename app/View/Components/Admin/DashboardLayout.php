<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class DashboardLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Collection $nodes, public ?string $previewUrl = null, public bool $start = false)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.dashboard-layout');
    }
}
