<?php

namespace App\View\Components\MediaLibrary;

use Illuminate\View\Component;
use App\Models\Metadata;

class Image extends Component
{
    public $metadata;
    
    public function __construct(Metadata $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.media-library.image', $data);
    }
}
