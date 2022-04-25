<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\{Comment,Post};

class CommentPolicy
{
    use HandlesAuthorization;

    const COMMENTS_PER_DAY = 180;
    
    public function store(User $user, $data) {
        /**
         * First we check if user exceed the limit of comments per day
         */
        if($user->comments()->count() > self::COMMENTS_PER_DAY) {
            /** Log this authorization break */
            return $this->deny(__('You have reached the maximum comments allowed per day.'));
        }
        /**
         * Then we check if the post owner disable comments or not
         */
        $post = Post::find($data['post_id']);
        if(!$post->allow_comments) {
            /** Log this authorization break */
            return $this->deny(__('The author is not currently accepting comments on this post.'));
        }
        /**
         * Then check if user is banned (we'll implement this step later)
         */

        return true;
    }
}
