<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqPolicy
{
    use HandlesAuthorization;

    const MAX_DAILY_FAQS = 6;

    public function store(User $user)
    {
        if($user->faqs()->today()->count() >= self::MAX_DAILY_FAQS) {
            /** Log this authorization break */
            return $this->deny(__('You reach your limited number of questions to ask per day, please try again later.'));
        }

        return true;
    }
}
