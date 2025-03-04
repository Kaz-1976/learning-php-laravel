<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageBox extends Component
{
    public string $imageId;
    public string $imageType;
    public string $imageData;
    public string $imageAlt;
    public string $imageTitle;

    /**
     * Create a new component instance.
     */
    public function __construct(string $imageId, string $imageType = '', string $imageData = '', string $imageAlt = '', string $imageTitle = '')
    {
        //
        $this->imageId = $imageId;
        $this->imageType = $imageType;
        $this->imageData = $imageData;
        $this->imageAlt = $imageAlt;
        $this->imageTitle = $imageTitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image-box');
    }
}
