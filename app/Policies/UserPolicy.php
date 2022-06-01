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

    public function deactivate_account(User $user) {
        if($user->status == 'deactivated') {
            /** Log unauthorized action */
            return $this->deny(__('Account already deactivated'));
        }
        
        return true;
    }

    public function activate_account(User $user) {
        if($user->status != 'deactivated') {
            /** Log unauthorized action */
            return $this->deny(__('Account already activated'));
        }
        
        return true;
    }

    public function ban_user(User $user, $u) {
        if(!$user->has_permission('ban-user')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        if($u->is_banned()) {
            return $this->deny("User already banned");
        }

        if($user->id == $u->id) {
            return $this->deny("You cannot ban your account.");
        }

        return true;
    }
}
