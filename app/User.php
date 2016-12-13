<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     
    protected $fillable = [
        'fullname', 'email', 'password','login','birthday','address','city','state','country','zip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function articles() {
		return $this->hasMany('App\Article');
	}
    
    public function roles() {
		return $this->belongsToMany('App\Role','role_user');
	}
	
	//
	//
	public function canDo($permission, $require = FALSE) {
		if(is_array($permission)) {
			foreach($permission as $permName) {
				
				$permName = $this->canDo($permName);
				if($permName && !$require) {
					return TRUE;
				}
				else if(!$permName  && $require) {
					return FALSE;
				}				
			}
			
			return  $require;
		}
		else {
			foreach($this->roles as $role) {
				foreach($role->perms as $perm) {
					//foo*    foobar
					if(str_is($permission,$perm->name)) {
						return TRUE;
					}
				}
			}
		}
	}
	
	// string  ['role1', 'role2']
	public function hasRole($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName);

                if ($hasRole && !$require) {
                    return true;
                } elseif (!$hasRole && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->roles as $role) {
                if ($role->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }
}
