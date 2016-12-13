<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UsersRepository;

use App\Http\Requests\UserRequest;

use Auth;
use App\User;

use Gate;

class ProfileController extends SiteController
{
    
	protected $us_rep;
	//
    public function __construct(UsersRepository $us_rep) {
    	
    	parent::__construct();
		
		$this->us_rep = $us_rep;
    	$this->template = config('settings.theme').'.profile';
		
	}
	
	public function create()
    {
        //
		
		$this->title =  'New user';
		
		if (Gate::denies('create',Auth::user())) {
            return redirect()->route('profile');
        }
        
        $canRole = FALSE;
        if(Gate::allows('ADD_ROLEUSER')) {
			$canRole = TRUE;
		}
		
		$roles = $this->getRoles()->reduce(function ($returnRoles, $role) {
		    $returnRoles[$role->id] = $role->name;
		    return $returnRoles;
		}, []);;
		
		$content = view(config('settings.theme').'.content-users-create')->with(['roles'=>$roles,'canRole' => $canRole])->render();
        $this->vars = array_add($this->vars,'content', $content);
		
        return $this->renderOutput();
    }
	
	
	
	public function store(UserRequest $request)
    {
        //
		$result = $this->us_rep->addUser($request);
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		return redirect()->route('users')->with($result);
    }
	
	public function show($id = FALSE) {
		
		$edit = FALSE;
		$delete = FALSE;
		
		$user = $this->us_rep->one($id);
		
		if($user) {
			if(Auth::check()) {
				if($user->id == Auth::user()->id || Gate::allows('EDIT_USER')) {
					$edit = TRUE;
				}
				
				if($user->id == Auth::user()->id || Gate::allows('DELETE_USER')) {
					$delete = TRUE;
				}
			}
			
			$user = $user->makeHidden(['created_at','updated_at'])->toArray();
		}

		$content = view(config('settings.theme').'.content-profile')
														->with(['user'=>$user,'edit'=>$edit,'delete'=>$delete])
														->render();
		$this->vars = array_add($this->vars,'content', $content);
		
		$this->title = 'Profile';
		
		return $this->renderOutput();
	}
	
	public function index() {
		
		$users = $this->us_rep->get(['id','fullname','email','city','country'],FALSE,TRUE);

		$content = view(config('settings.theme').'.content-users')->with('users',$users)->render();
		$this->vars = array_add($this->vars,'content', $content);
		$this->title = "Users";
		return $this->renderOutput();
	}
	
	public function edit(User $user) {
		
		
		if (Gate::denies('edit',$user)) {
            return redirect()->route('profile');
        }
        
        $canRole = FALSE;
        if(Gate::allows('ADD_ROLEUSER')) {
			$canRole = TRUE;
		}
		
		$roles = $this->getRoles()->reduce(function ($returnRoles, $role) {
		    $returnRoles[$role->id] = $role->name;
		    return $returnRoles;
		}, []);
		

		$content = view(config('settings.theme').'.content-users-edit')
													->with(['user'=>$user,'roles'=>$roles,'canRole' => $canRole])
													->render();
		$this->vars = array_add($this->vars,'content', $content);
		
		return $this->renderOutput();
	}
	
	public function getRoles() {
		return \App\Role::all();
	}
	
	 public function update(UserRequest $request, User $user)
    {
        //
		
		$result = $this->us_rep->updateUser($request,$user);
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		return redirect()->route('users')->with($result);
    }
	
	public function delete(User $user) {

		$result = $this->us_rep->deleteUser($user);
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		return redirect()->route('users')->with($result);
	}
}
