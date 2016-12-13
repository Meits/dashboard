<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Repositories\CommentsRepository;

use Validator;
use Auth;
use App\Comment;
use App\Article;
use Gate;

class CommentController extends SiteController
{

    
    public function __construct(CommentsRepository $c_rep) {
    	
    	parent::__construct();
    	
    	$this->c_rep = $c_rep;
    	
    	$this->template = config('settings.theme').'.index';
		
	}
    
    public function store(Request $request)
    {
        //
        
        $data = $request->except('_token','comment_post_ID','comment_parent');
        
        $data['article_id'] = $request->input('comment_post_ID');
        $data['parent_id'] = $request->input('comment_parent');
        $data['text'] = strip_tags($data['text']);
        
        $validator = Validator::make($data,[
        
        	'article_id' => 'integer|required',
        	'parent_id' => 'integer|required',
        	'text' => 'string|required'
        
        ]);
        
        $validator->sometimes(['name','email'],'required|max:255',function($input) {
        	
        	return !Auth::check();
        	
        });
        
        if($validator->fails()) {
			return \Response::json(['error'=>$validator->errors()->all()]);
		}
		
		$user = Auth::user();
		
		$comment = new Comment($data);
		
		$data['edit_delete'] = FALSE;
		
		if($user) {
			$comment->user_id = $user->id;
			$data['edit_delete'] = TRUE;
		}
		
		$post = Article::find($data['article_id']);
		
		$post->comments()->save($comment);
		
		$comment->load('user');
		$data['id'] = $comment->id;
		
		$data['email'] = (!empty($data['email'])) ? $data['email'] : $comment->user->email;        
		$data['name'] = (!empty($data['name'])) ? $data['name'] : $comment->user->fullname;        
		
		$data['created_at'] = date('F d, Y',time());
		
		$data['hash'] = md5($data['email']);
		
		$view_comment = view(config('settings.theme').'.content_one_comment')->with('data',$data)->render();
		
		return \Response::json(['success' => TRUE,'comment'=>$view_comment,'data' => $data]);
        
        exit();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
         //
         
        if(Gate::denies('edit', $comment)) {
			abort(403);
		}
        
        $data = $request->except('_token','comment_post_ID','comment_parent','parent_id');
        
        //$data['article_id'] = $request->input('comment_post_ID');
        //$data['parent_id'] = $request->input('comment_parent');
        
        $data['text'] = strip_tags($data['text']);
        
        $validator = Validator::make($data,[
        
        	//'article_id' => 'integer|required',
        	//'parent_id' => 'integer|required',
        	'text' => 'string|required'
        
        ]);
        
        $validator->sometimes(['name','email'],'required|max:255',function($input) {
        	
        	return !Auth::check();
        	
        });
        
        if($validator->fails()) {
			return \Response::json(['error'=>$validator->errors()->all()]);
		}
		
		$comment->fill($data);
		
		$comment->update();
		
		$comment->load('user');
		$data['id'] = $comment->id;
		
		$data['email'] = (!empty($data['email'])) ? $data['email'] : (isset($comment->user->email)) ? $comment->user->email : '';        
		$data['name'] = (!empty($data['name'])) ? $data['name'] : (isset($comment->user->email)) ? $comment->user->email : '';        
		
		$data['article_id'] = $request->input('comment_post_ID');
		
		$data['created_at'] = date('F d, Y',time());
		
		$data['hash'] = md5($data['email']);
		
		$data['edit_delete'] = TRUE;
		
		$view_comment = view(config('settings.theme').'.content_one_comment')->with('data',$data)->render();
		
		
		return \Response::json(['success' => TRUE,'comment'=>$view_comment,'data' => $data,'edit'=>TRUE]);
        
        exit();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if(Gate::denies('destroy', $comment)) {
			abort(403);
		}
		
		if($this->c_rep->get('*',FALSE,FALSE,['parent_id',$comment->id])) {
			return \Response::json(['error' => ['have children']]);
			exit();
		}
		
		
		if($comment->delete()) {
			return \Response::json(['success' => TRUE]);
		}
		
        
        exit();
		
    }
}
