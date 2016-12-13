<?php

namespace App\Repositories;

use App\User;
use Config;
use Gate;
use Auth;



class UsersRepository extends Repository
{
	protected $user = FALSE;
    
	public function __construct(User $user) {
		$this->model  = $user;
	}
	
	public function one($id = FALSE, $alias = FALSE,$attr = array()) {
		
		if(!$id) {
			$this->user = $this->user ? $this->user : Auth::user();
		}
		else {
			
			return parent::one($id, $alias,$attr);
		}
		return $this->user;
	}
	
	public function addUser($request) {
		
		
		if (\Gate::denies('create',$this->model)) {
            abort(403);
        }
		
		$data = $request->all();
		
		$user = User::create([
            'fullname' => $data['fullname'],
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'birthday' => $data['birthday'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'zip' => $data['zip']
        ]);
		
		if($user) {
			$user->roles()->attach($data['role_id']);
		}
		
		return ['status' => 'Add'];
		
	}
	
	public function updateUser($request, $user) {
		
		
		if (\Gate::denies('edit',$user)) {
			abort(403);
        }
		
		$data = $request->all();
		
		if(isset($data['password']) && !empty($data['password'])) {
			$data['password'] = bcrypt($data['password']);
		}
		else {
			unset($data['password']);
		}
		
		
		$user->fill($data)->update();
		
		if(isset($data['role_id'])) {
			$user->roles()->sync([$data['role_id']]);
		}
		return ['status' => 'Update'];
		
	}
	
	public function deleteUser($user) {
		
		if (Gate::denies('delete',$user)) {
            abort(403);
        }
        if($user->hasRole('Administrator')) {
			return ['error' => 'Administrator - delete'];
		}
		
		$user->roles()->detach();
		
		if($user->delete()) {
			
			if($user->id == Auth::user()->id) {
				Auth::logout();
				
				
			}
			return ['status' => 'User delete'];	
		}
	}
	
	

	
}