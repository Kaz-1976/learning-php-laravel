<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardBox extends Component
{
    public string $direction;
    public bool $responsive;

    /**
     * Create a new component instance.
     */
    public function __construct(string $direction = 'col', bool $responsive = false)
    {
        //
        $this->direction = $direction;
        $this->responsive = $responsive;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card-box');
    }
}
