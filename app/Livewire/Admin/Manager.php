<?php

use Livewire\Component;

new class extends Component
{
    public $picture_url = '';

    public $picture_id = 0;

    public $forward_id = 0;

    public $right_id = 0;

    public $left_id = 0;

    public $back_id = 0;

    public function save($picture_url)
    {
        $pictures = [];

        $pictures[] = $picture_url;

    }

    public function render()
    {
        return view('livewire\component\admin\manager');
    }
};
?>

