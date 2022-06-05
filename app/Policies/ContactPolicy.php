<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function read(User $user) {
        if(!$user->has_permission('read-contact-message')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }
        
        return true;
    }
}
