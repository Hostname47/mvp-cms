<?php

namespace App\View\Components\Admin\Author\Viewers;

use Illuminate\View\Component;
use App\Models\AuthorRequest;

class ReviewViewer extends Component
{
    public $request;
    
    public function __construct(AuthorRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.author.viewers.review-viewer', $data);
    }
}
