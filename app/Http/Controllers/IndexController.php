<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticlesRepository;

use Gate;
use Auth;

use App\User;

use App\Article;


class IndexController extends SiteController
{
    protected $a_rep;

    //
    public function __construct(ArticlesRepository $a_rep) {
    	
    	parent::__construct();

    	$this->a_rep = $a_rep;
    	$this->template = config('settings.theme').'.index';
		
	}
	
	public function index($text = FALSE,$city = FALSE,$user = FALSE) {
		
		$articles = array();
		
		if(!$text && !$city && !$user) {
			$articles = $this->getArticles();
			
			$this->title = 'List Messages - Search Results';
		}
		else {

			$this->title = 'List Messages - Home';
			
			$builder = Article::select('*');
			
			if($text) {
				$builder->where('text', 'like', '%'.$text.'%');
			}
			
			if($user) {
				if($builder) {
					$builder->whereHas('user',function($query) use ($user) {
						$query->where('id',$user); 
					});
				}
				else{
					$builder = User::find($user)->articles();
				}
			}
			else if($city) {
				
				if($builder) {
					$builder->whereHas('user',function($query) use ($city) {
						$query->where('city','LIKE BINARY',$city); 
					});
				}
				else {
					$builder = Article::whereHas('user',function($query) use ($city) {
						$query->where('city',$city); 
					});
				}
				
			}
			
			$articles = $builder->paginate(config('settings.paginate'));
			$articles->transform(function ($item, $key) {
				
			    $item->img = json_decode($item->img);
				return $item;
				
			});
		}
		
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

		return $this->renderOutput();
	}
	
	public function show($id) {
		
		$edit = FALSE;
		$delete = FALSE;
			
		$edit_c = FALSE;
		$delete_c = FALSE;
		
		$article = $this->a_rep->one($id,FALSE,['comments' => TRUE]);
		
		if($article) {
			
			$this->title = 'Message - '.$article->title; 
			
			if(Auth::check()) {
				if(($article->user->id == Auth::user()->id) || Gate::allows('edit', $article)) {
					$edit = TRUE;
				}

				if(($article->user->id == Auth::user()->id) || Gate::allows('destroy',$article)) {
					$delete = TRUE;
				}
			}
			$article->img = json_decode($article->img);
		}
		else {
			$article = FALSE;
		}
		
		
		$content = view(config('settings.theme').'.article-content')
													->with(['article'=>$article,'edit' => $edit, 'delete'=>$delete])
													->render();
													
		$this->vars = array_add($this->vars,'content',$content);
		
		

		return $this->renderOutput();
	}
	
	public function getArticles() {
		
		$articles = $this->a_rep->get(['id','title','created_at','img','user_id','text'],FALSE,TRUE);
		
		if($articles) {
			$articles->load('user','comments');
		}
		
		return $articles;
		
	}
	
	public function create()
    {
		if(Gate::denies('save', new \App\Article)) {
			abort(403);
		}
		
		$this->title = "Add article";
		
		$content = view(config('settings.theme').'.content-messages-create')->render();
		$this->vars = array_add($this->vars,'content', $content);
		return $this->renderOutput();
    }
    
    public function store(ArticleRequest $request)
    {
        //
		$result = $this->a_rep->addArticle($request);
		
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		
		return redirect()->route('home')->with($result);
    }
    
    public function edit(Article $article)
    {

        if(Gate::denies('edit', $article)) {
			abort(403);
		}
		
		if(isset($article->img)) {
			$article->img = json_decode($article->img);
		}

		$content = view(config('settings.theme').'.content-messages-create')->with(['article' => $article])->render();
		$this->vars = array_add($this->vars,'content', $content);
		return $this->renderOutput();
		
		
    }
    
    public function update(ArticleRequest $request, Article $article)
    {
        //
        $result = $this->a_rep->updateArticle($request, $article);
		
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		
		return redirect()->route('home')->with($result);
        
    }
    
    public function destroy(Article $article)
    {
        //
        $result = $this->a_rep->deleteArticle($article);
		
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		
		return redirect()->route('home')->with($result);
        
    }
}
