<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Admin actions
     */
    public function store(User $user) {
        if(!$user->has_permission('create-category')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function update(User $user) {
        if(!$user->has_permission('update-category')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function delete(User $user) {
        if(!$user->has_permission('delete-category')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }
}
