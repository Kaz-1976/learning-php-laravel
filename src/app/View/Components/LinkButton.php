<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LinkButton extends Component
{

    public string $linkType;
    public string $linkTo;
    public string $linkInputName;
    public string $linkInputValue;
    public string $linkButtonName;

    /**
     * Create a new component instance.
     */
    public function __construct(string $linkType, string $linkTo, string $linkInputName = '', string $linkInputValue = '', string $linkButtonName = '')
    {
        //
        $this->linkType = $linkType;
        $this->linkTo = $linkTo;
        $this->linkInputName = $linkInputName;
        $this->linkInputValue = $linkInputValue;
        $this->linkButtonName = $linkButtonName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.link-button');
    }
}
