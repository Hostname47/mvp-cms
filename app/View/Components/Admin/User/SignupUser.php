<?php

namespace App\View\Components\Admin\User;

use Illuminate\View\Component;
use App\Models\User;

class SignupUser extends Component
{
    public $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.signup-user', $data);
    }
}
