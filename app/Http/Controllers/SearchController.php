<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticlesRepository;

use Gate;
use Auth;

use App\User;

use App\Article;

use Session;


class SearchController extends SiteController
{
    //
    
    protected $a_rep;
     //
    public function __construct(ArticlesRepository $a_rep) {
    	
    	parent::__construct();
    	
    	$this->a_rep = $a_rep;
    	
    	$this->template = config('settings.theme').'.index';
		
	}
    
    
    public function index(Request $request) {
    	
    	
		$sData = $request->all();
		
		session(array('text'=>$sData['search_text'] ? $sData['search_text'] : 0,'city'=>$sData['city'],'user'=>$sData['user_id']));
		
		return redirect()->route('searchList',array('text'=>$sData['search_text'] ? $sData['search_text'] : 0,'city'=>$sData['city'],'user'=>$sData['user_id']));
		
		/*$articles = array();
		$builder = Article::select('*');
		
		if($sData['search_text']) {
			$builder->where('text', 'like', '%'.$sData['search_text'].'%');
		}
		
		if($sData['user_id']) {
			if($builder) {
				$builder->whereHas('user',function($query) use ($sData) {
					$query->where('id',$sData['user_id']); 
				});
			}
			else{
				$builder = User::find($sData['user_id'])->articles();
			}
		}
		else if($sData['city']) {
			/*$users = User::where('city',$sData['city'])->has('articles')->get();*/
			/*if($builder) {
				$builder->whereHas('user',function($query) use ($sData) {
					$query->where('city',$sData['city']); 
				});
			}
			else {
				$builder = Article::whereHas('user',function($query) use ($sData) {
					$query->where('city',$sData['city']); 
				});
			}
			
		}
		
		$articles = $builder->paginate(config('settings.paginate'));
		
		$articles->transform(function ($item, $key) {
			
		    $item->img = json_decode($item->img);

			return $item;
			
		});*/
		
		//dd($articles);
		
		$users_tmp = User::all();
		$users = $users_tmp->reduce(function ($returnUsers, $user) {
		    $returnUsers[$user->id] = $user->fullname;
		    return $returnUsers;
		}, ['0' => 'Don`t use']);
		
		$citys = $users_tmp->unique('city');
		$citys = $citys->reduce(function ($returnUsers, $user) {
		    $returnUsers[$user->city] = $user->city;
		    return $returnUsers;
		}, ['0' => 'Don`t use']);
		
		
		$sideBar = view(config('settings.theme').'.sideBar')->with(['users'=>$users,'cyties'=>$citys])->render();
		
		$content = view(config('settings.theme').'.content')->with(['articles'=>$articles,'sideBar'=>$sideBar])->render();
		$this->vars = array_add($this->vars,'content', $content);
		
		$this->title = 'Search results';

		return $this->renderOutput();
	}
}
