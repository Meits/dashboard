<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;

use App\Article;

class ArticlePolicy
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
    
    public function save(User $user) {
		return $user->canDo('ADD_MESS');
	}
	
	public function edit(User $user,Article $article) {
		
		return ($user->canDo('EDIT_MESS')  || $user->id == $article->user_id);
	}
	
	public function destroy(User $user, Article $article) {
		return ($user->canDo('DELETE_MESS')  || $user->id == $article->user_id);
	}
	
	
  }
