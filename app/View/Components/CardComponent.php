<?php

namespace App\View\Components;

use Closure;
use http\Header;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardComponent extends Component
{
    /**
     * Create a new component instance.
     */
    private string $classCard;
    private string $title;
    private string $header;

private string $bodyClass;

    public function __construct($classCard, $title='',$header='', $bodyClass='')
    {
        $this->classCard = $classCard;
        $this->title = $title;
        $this->header = $header;
        $this->bodyClass = $bodyClass;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card-component',[
            'classCard' => $this->classCard,
            'title' => $this->title,
            'header' => $this->header,
            'bodyClass' => $this->bodyClass,
        ]);
    }
}
