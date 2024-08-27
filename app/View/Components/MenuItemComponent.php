<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuItemComponent extends Component
{
    public $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function render()
    {
        return view('components.menu-item-component');
    }
}
