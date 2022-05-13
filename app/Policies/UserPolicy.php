<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function set_password(User $user) {
        if(!is_null($user->password)) {
            /** Log unauthorized action */
            return $this->deny(__('Unauthorized action. A log entry of this action will be reviewed by our admins'));
        }
        
        return true;
    }

    public function update_password(User $user) {
        if(is_null($user->password)) {
            /** Log unauthorized action */
            return $this->deny(__('Unauthorized action. A log entry of this action will be reviewed by our admins'));
        }
        
        return true;
    }
}