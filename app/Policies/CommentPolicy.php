<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\{Comment,Post};
use Purifier;

class CommentPolicy
{
    use HandlesAuthorization;

    const COMMENTS_PER_DAY = 160;
    
    public function store(User $user, $data, $post) {
        // Verify comment content
        if(Purifier::clean($data['content']) == '') {
            /** log this unauthorized break */
            return $this->deny(__('Content field is required.'));
        }

        // If the post is null (not found), then we simply stop the execution
        if(is_null($post)) {
            return $this->deny(__('Post not found.'));
        }
        /**
         * First we check if user exceed the limit of comments per day
         */
        if($user->comments()->count() >= self::COMMENTS_PER_DAY) {
            /** Log this authorization break */
            return $this->deny(__('You have reached the maximum comments allowed per day.'));
        }
        /**
         * Then we check if the post owner disable comments or not
         */
        $post = Post::find($data['post_id']);
        if(!$post->allow_comments) {
            /** Log this authorization break */
            return $this->deny(__('The author is not currently accepting comments on this post'));
        }
        /**
         * Then we check if the post is not private
         */
        if($post->visibility == 'private' && $user->id != $post->user_id) {
            /** Log this authorization break */
            return $this->deny(__('Oops something went wrong.'));
        }
        /**
         * Then check if user is banned (we'll implement this step later)
         */

        return true;
    }

    public function able_to_update(User $user, $comment) {
        return $user->id == $comment->user_id;
    }

    public function update(User $user, $data, $comment) {
        // Verify comment content
        if(Purifier::clean($data['content']) == '') {
            /** log this unauthorized break */
            return $this->deny(__('Content field is required.'));
        }
        /**
         * we check if the comment owner is the one who is trying to update
         */
        if($user->id != $comment->user_id) {
            /** Log this authorization break */
            return $this->deny(__('Unauthorized action. A snapshot of details is sent to admins to review'));
        }

        return true;
    }

    public function delete(User $user, $comment, $post) {
        /**
         * we check if the comment owner is the one who is trying to update
         */
        if($user->id != $comment->user_id){
            /** Log this authorization break */
            return $this->deny(__('Unauthorized action. A snapshot of details is sent to admins to review'));
        }

        return true;
    }

    public function able_to_delete(User $user, $comment) {
        return $user->id == $comment->user_id;
    }

    /**
     * Authorization of report is done in report policy
     */
    public function able_to_report(User $user, $comment) {
        return $user->id != $comment->user_id;
    }
}
