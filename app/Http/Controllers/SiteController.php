<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Menu;
use Auth;
use Gate;

class SiteController extends Controller
{
    protected $vars = array();
    protected $title = FALSE;
    
    //
    public function __construct() {
		return TRUE;
	}
	
	protected function renderOutput() {
		
		$menu = $this->getMenu();
		$navigation = view(config('settings.theme').'.navigation')->with('menu',$menu)->render();
		$this->vars = array_add($this->vars,'navigation',$navigation);
		
		$footer = view(config('settings.theme').'.footer')->render();
		$this->vars = array_add($this->vars,'footer',$footer);
		
		$this->vars = array_add($this->vars,'title',$this->title);
		
		return view($this->template)->with($this->vars);
	}
	
	protected function getMenu() {	
		
		
		$menu = Menu::make('MyNavBar', function($menu){

				  $menu->add('Home',array('route'  => 'home'));
				  $menu->add('Users',array('route'  => 'users'));
				  if(!Auth::check()) {
				  	$menu->add('LogIn',array('route'  => 'login'));
				  	$menu->add('Register', array('route'  => 'register'));
				  }
				  
				  if(Auth::check()) {
				  	$menu->add('Profile', array('route'  => 'profile'));
				  	if(Gate::allows('ADD_MESS')) {
						$menu->add('Add message', array('route'  => 'article-add'));
					}
					if(Gate::allows('ADD_USER')) {
						$menu->add('Add User', array('route'  => 'user-add'));
					}
				  }
				  

				});
		return $menu;
	}
}
