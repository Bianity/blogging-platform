<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Comment $comment)
    {
        if ($user->can('edit_comments')) {
            return $user->id === $comment->user_id || $user->isAdmin() || $user->isModerator();
        }
    }

    public function delete(User $user, Comment $comment)
    {
        if ($user->can('delete_comments')) {
            return $user->id === $comment->user_id || $user->isAdmin() || $user->isModerator();
        }
    }
}
