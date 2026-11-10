<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class AdminButton extends Component
{
public $text;
public $color;
public $action;

public function __construct($text, $color = 'bg-gray-200', $action = '')
{
    $this->text = $text;
    $this->color = $color;
    $this->action = $action;
}

    public function render()
    {
        return view('components.admin.admin-button');
    }
}