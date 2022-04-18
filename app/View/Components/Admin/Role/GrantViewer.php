<?php

namespace App\View\Components\Admin\Role;

use Illuminate\View\Component;
use App\Models\{User,Role};

class GrantViewer extends Component
{
    public $role;
    public $user;

    public function __construct(Role $role, User $user)
    {
        $this->role = $role;
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.role.grant-viewer', $data);
    }
}
