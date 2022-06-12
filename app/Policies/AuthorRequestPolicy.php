<?php

namespace App\Policies;

use App\Models\{User,AuthorRequest};
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorRequestPolicy
{
    use HandlesAuthorization;

    public function request(User $user) {
        if(AuthorRequest::where('user_id', $user->id)->count()) {
            /** log unauthorized action */
            return $this->deny(__('You have already sent an author request before'));
        }

        // if($user->has_role('author')) {
        //     /** log unauthorized action */
        //     return $this->deny(__('Author role already acquired'));
        // }

        return true;
    }

    public function accept(User $user, $u, $request) {
        if(!$user->has_permission('accept-author-request')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        if(is_null($u)) {
            return $this->deny("Author request user is not available.");
        }

        return true;
    }

    public function refuse(User $user) {
        if(!$user->has_permission('refuse-author-request')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }

    public function delete(User $user) {
        if(!$user->has_permission('delete-author-request')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }
}
