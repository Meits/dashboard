<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;

use App\Comment;

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

	
	public function edit(User $user,Comment $comment) {
		
		return ($user->canDo('EDIT_COMMENTS')  || $user->id == $comment->user_id);
	}
	
	public function destroy(User $user, Comment $comment) {
		return ($user->canDo('DELETE_MESS')  || $user->id == $comment->user_id);
	}
	
	
  }
