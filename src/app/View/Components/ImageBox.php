<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageBox extends Component
{
    public bool $border;
    public string $imageId;
    public string $imageType;
    public string $imageData;

    /**
     * Create a new component instance.
     */
    public function __construct(string $imageId, string $imageType = '', string $imageData = '', bool $border = false)
    {
        //
        $this->border = $border;
        $this->imageId = $imageId;
        $this->imageType = $imageType;
        $this->imageData = $imageData;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image-box');
    }
}
