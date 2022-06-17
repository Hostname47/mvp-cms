<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function store(User $user) {
        if(!$user->has_permission('create-post')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function update(User $user) {
        if(!$user->has_permission('update-post')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function update_status(User $user) {
        if(!$user->has_permission('change-post-status')) {
            $user->log_authbreak([
                'action'=>'Try to change post status without permission',
            ]);
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function preview(User $user) {
        if(!$user->has_permission('preview-post')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function trash(User $user) {
        if(!$user->has_permission('trash-post')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function restore(User $user) {
        if(!$user->has_permission('restore-post')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function destroy(User $user) {
        if(!$user->has_permission('destroy-post')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }
}
