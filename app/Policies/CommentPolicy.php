<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function writeComment(User $currentUser, $userId)
    {
        if ($userId != $currentUser->id) {
            return Response::allow();
        }
        return Response::deny();
    }

    public function replyComment(User $currentUser, Comment $comment)
    {
        if ($comment->sender_id != $currentUser->id) {
            return Response::allow();
        }
        return Response::deny();
    }

    public function deleteComment(User $user, Comment $comment)
    {
        if ($comment->findFirstParent()->receiver_id == $user->id || $comment->sender_id == $user->id) {
            return Response::allow();
        }
        return Response::deny();
    }
}
