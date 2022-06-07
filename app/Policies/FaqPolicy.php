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

    public function update_priorities(User $user, $data) {
        if(!$user->has_permission('update-faq-priority')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }
        
        if(count($data['faqs']) != count($data['priorities'])) {
            return $this->deny("Number of priorities should be the same as number of priorities values");
        }

        return true;
    }

    public function update(User $user) {
        if(!$user->has_permission('update-faq')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }

        return true;
    }
}
