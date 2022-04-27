<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\{Comment,Post};

class ClapPolicy
{
    use HandlesAuthorization;

    const CLAPS_PER_DAY = 200;

    public function clap(User $user, $resource) {
        if(!$resource)
            return $this->deny(__('Oops something went wrong.'));

        /**
         * First we check if user exceed the limit of claps per day
         */
        if($user->claps()->count() >= self::CLAPS_PER_DAY) {
            /** Log this authorization break */
            return $this->deny(__('You have reached the maximum claps allowed per day.'));
        }

        /**
         * Then we check if the clapable resource does not allow reactions (like post with claps disabled)
         */
        if(array_key_exists('allow_reactions', $resource->getAttributes()) && !$resource->allow_comments) {
            /** Log this authorization break */
            return $this->deny(__('Resource owner is not currently accepting reactions on this.'));
        }

        return true;
    }
}
