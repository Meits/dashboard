<?php

namespace App\Repositories;

use App\Article;
use Config;

use Gate;
use Image;

class ArticlesRepository extends Repository
{
	
    
	public function __construct(Article $article) {
		$this->model  = $article;
	}
    
    public function one($id = FALSE, $alias = FALSE,$attr = array()) {
		
		$article = parent::one($id,$alias,$attr);
		if($article && $attr['comments']) {
			$article->load('comments');
			$article->comments->load('user');
			
		}
		return $article;	
	}
    
    protected function check($articles) {
		
		if($articles->isEmpty()) {
			return FALSE;
		}
		
		$articles->transform(function ($item, $key) {
			
		    $item->img = json_decode($item->img);
			
			$item->text = strip_tags($item->text);
		    $item->text = str_limit($item->text,160);
		   	$item->text = substr($item->text,0,strrpos($item->text,' '));
			return $item;
			
		});
		
		return $articles;
	}
	
	public function addArticle($request) {
		
		if (Gate::denies('save',$this->model)) {
            abort(403);
        }
		
		$data = $request->except('_token','image');
		if(empty($data)) {
			return ['error'=>'Нет данных'];
		}
		
		
		if($request->hasFile('image')) {
			$image = $request->file('image');
	
			if($image->isValid()) {
				
				$image = Image::make($image);
				$str = str_random(8);
				
				$obj = new \stdClass;
				$obj->mini = $str.'_mini.jpg';
				$obj->max = $str.'_max.jpg';
				$obj->path = $str.'.jpg';

				$path = $image->fit(Config::get('settings.image')['width'],Config::get('settings.image')['height'], function ($constraint) {
											    $constraint->upsize();
											})->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->path);
				
				$mini = $image->fit(Config::get('settings.articles_img')['max']['width'],Config::get('settings.articles_img')['max']['height'], function ($constraint) {
				    $constraint->upsize();
				})->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->max);
				
				$max = $image->fit(Config::get('settings.articles_img')['mini']['width'],Config::get('settings.articles_img')['mini']['height'],
										function ($constraint) {
										    $constraint->upsize();
										})->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->mini);
				
				$data['img'] = json_encode($obj);
	
			}
		}
		
		
		
		$this->model->fill($data);
		
		if($request->user()->articles()->save($this->model)) {
			return ['status' => 'Article Save'];
		}
		
	}
	
	public function updateArticle($request,$article) {
		
		if (Gate::denies('edit',$article)) {
            abort(403);
        }
		
		$data = $request->except('_token','image');
		
		if(empty($data)) {
			return ['error'=>'Empty data'];
		}
		
		
		if($request->hasFile('image')) {
			$image = $request->file('image');
	
			if($image->isValid()) {
				
				$image = Image::make($image);

				$str = str_random(8);
				
				$obj = new \stdClass;
				$obj->mini = $str.'_mini.jpg';
				$obj->max = $str.'_max.jpg';
				$obj->path = $str.'.jpg';
				
				$path = $image->fit(Config::get('settings.image')['width'],Config::get('settings.image')['height'], function ($constraint) {
											    $constraint->upsize();
											})->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->path);
				
				$mini = $image->fit(Config::get('settings.articles_img')['max']['width'],Config::get('settings.articles_img')['max']['height'], function ($constraint) {
				    $constraint->upsize();
				})->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->max);
				
				$max = $image->fit(Config::get('settings.articles_img')['mini']['width'],Config::get('settings.articles_img')['mini']['height'],
										function ($constraint) {
										    $constraint->upsize();
										})->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->mini);
				
				$data['img'] = json_encode($obj);
	
			}
		}
		
		
		
		$article->fill($data);
		
		if($article->update()) {
			return ['status' => 'Article update'];
		}
		
	}
	
	public function deleteArticle($article) {
		
		
		if (Gate::denies('destroy',$article)) {
            abort(403);
        }

		$article->comments()->delete();
		
		if($article->delete()) {
			return ['status' => 'Article delete'];	
		}
		
	}
}