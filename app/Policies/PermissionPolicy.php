<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function store(User $user) {
        if(!$user->has_permission('create-permission')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function update(User $user) {
        if(!$user->has_permission('update-permission')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function delete(User $user) {
        if(!$user->has_permission('delete-permission')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function attach_permission_to_user(User $user) {
        if(!$user->has_permission('attach-permission-to-user')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }
        
        return true;
    }

    public function detach_permission_from_user(User $user) {
        if(!$user->has_permission('detach-permission-from-user')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }
}
