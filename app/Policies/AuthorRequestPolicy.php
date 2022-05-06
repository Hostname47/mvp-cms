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

        if($user->has_role('author')) {
            /** log unauthorized action */
            return $this->deny(__('Author role already acquired'));
        }

        return true;
    }
}
