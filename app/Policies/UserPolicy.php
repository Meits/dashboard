<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class UserPolicy
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
	
	public function create(User $user)
    {
		return $user->can('ADD_USER');
    }
    
    public function edit(User $user,$edit)
    {
		
		return $user->can('EDIT_USER')  || ($edit->id == $user->id);
    }
    public function delete(User $user,$del)
    {
		
		return $user->can('DELETE_USER') || ($del->id == $user->id);
    }
}
