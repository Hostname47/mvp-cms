<?php

namespace App\View\Components\NewsLetter;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscriber;

class NewsletterSubscribeViewer extends Component
{
    public $subscribed;
    public $authenticated;
    
    public function __construct()
    {
        $this->authenticated = Auth::check();
        $this->subscribed = auth()->user() 
            && ($subscribe = Subscriber::where('email', auth()->user()->email)->first()) 
            && ($subscribe && $subscribe->status == 1);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.news-letter.newsletter-subscribe-viewer', $data);
    }
}
