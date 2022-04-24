<?php

namespace App\View\Components\NewsLetter;

use Illuminate\View\Component;
use App\Models\Subscriber;

class NewsletterSubscribeViewer extends Component
{
    public $subscribed;
    
    public function __construct()
    {
        $this->subscribed = auth()->user() 
            && ($subscribe = Subscriber::where('email', auth()->user()->id)->first()) 
            && ($subscribe && $subscribe->status == 1);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.news-letter.newsletter-subscribe-viewer');
    }
}
