<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Policies\UserPolicy;
use App\User;
use App\Article;
use App\Comment;
use App\Policies\ArticlePolicy;
use App\Policies\CommentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       User::class => UserPolicy::class,
       Article::class => ArticlePolicy::class,
       Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();
        
        $gate->define('EDIT_USER', function ($user) {
        	return $user->canDo('EDIT_USER', FALSE);
        });
        
        $gate->define('DELETE_USER', function ($user) {
        	return $user->canDo('DELETE_USER', FALSE);
        });
        
        $gate->define('ADD_ROLEUSER', function ($user) {
        	return $user->canDo('ADD_ROLEUSER', FALSE);
        });
        
        $gate->define('ADD_MESS', function ($user) {
        	return $user->canDo('ADD_MESS', FALSE);
        });
		
		$gate->define('ADD_USER', function ($user) {
        	return $user->canDo('ADD_USER', FALSE);
        });
        

        //
    }
}
