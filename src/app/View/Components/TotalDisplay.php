<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TotalDisplay extends Component
{

    public string $totalQty;
    public string $totalAmount;

    /**
     * Create a new component instance.
     */
    public function __construct(string $totalQty = '0', string $totalAmount = '0')
    {
        //
        $this->totalQty = (int) $totalQty;
        $this->totalAmount = (int) $totalAmount;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.total-display');
    }
}
