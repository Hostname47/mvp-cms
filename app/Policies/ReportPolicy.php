<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\{Comment,Post};

class ReportPolicy
{
    use HandlesAuthorization;

    const MAX_DAILY_REPORTS = 16;

    public function report(User $user, $data) {
        if($user->reportings()->count() >= self::MAX_DAILY_REPORTS) {
            /** Log this authorization break */
            return $this->deny(__('You have reached your maximum reports allowed per day.'));
        }
        
        $reportable = null;
        switch($data['reportable_type']) {
            case 'App\Models\Comment':
                $reportable = Comment::find($data['reportable_id']);
                break;
            case 'App\Models\Post':
                $reportable = Post::find($data['reportable_id']);
                break;
        }

        if(is_null($reportable))
            return $this->deny(__('Oops something went wrong.'));

        // User cannot report his own resources
        if($reportable->user_id == $user->id)
            return $this->deny(__('You cannot report your own resources.'));

        // User can report a resource only once
        $reported = $user->reportings()
            ->where('reportable_type', $data['reportable_type'])
            ->where('reportable_id', $data['reportable_id'])
            ->count() > 0;
        if($reported)
            return $this->deny(__("You have already reported this resource"));

        return true;
    }

    public function viewer(User $user, $reportable) {
        if(is_null($reportable))
            return $this->deny(__('Oops something went wrong.'));

        // User cannot report his own resources
        if($reportable->user_id == $user->id)
            return $this->deny(__('You cannot report your own resources.'));

        return true;
    }

    public function review(User $user) {
        if(!$user->has_permission('review-report')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }
        
        return true;
    }

    public function delete(User $user) {
        if(!$user->has_permission('delete-report')) {
            return $this->deny("Unauthorized action due to lack of permissions.");
        }
        
        return true;
    }
}
