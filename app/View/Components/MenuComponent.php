<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Menu;

class MenuComponent extends Component
{
    public $menus;

    public function __construct()
    {
        $this->menus = Menu::with(['children', 'roles'])
            ->whereNull('parent_id')
            ->orderBy('position')->get();
    }

    public function render()
    {
        return view('components.menu-component');
    }
}
