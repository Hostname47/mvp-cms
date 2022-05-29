<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function store(User $user) {
        if(!$user->has_permission('create-tag')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function update(User $user) {
        if(!$user->has_permission('update-tag')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function delete(User $user) {
        if(!$user->has_permission('delete-tag')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }
}
