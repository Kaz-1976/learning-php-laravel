<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TotalDisplay extends Component
{

    public string $totalQty;
    public string $totalPrice;

    /**
     * Create a new component instance.
     */
    public function __construct(string $totalQty = '0', string $totalPrice = '0')
    {
        //
        $this->totalQty = (int) $totalQty;
        $this->totalPrice = (int) $totalPrice;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.total-display');
    }
}
