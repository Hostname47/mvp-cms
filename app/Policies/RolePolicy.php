<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function store(User $user) {
        if(!$user->has_permission('create-role')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function update(User $user) {
        if(!$user->has_permission('update-role')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function delete(User $user) {
        if(!$user->has_permission('delete-role')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function attach_permission(User $user) {
        if(!$user->has_permission('attach-permission-to-role')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function detach_permission(User $user) {
        if(!$user->has_permission('detach-permission-from-role')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function grant(User $user) {
        if(!$user->has_permission('grant-role')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function revoke(User $user) {
        if(!$user->has_permission('revoke-role')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }
}
