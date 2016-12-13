<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    
    protected $fillable = ['title','img','text'];
	
    
    
    public function user() {
		return $this->belongsTo('App\User');
	}
	
	
	public function comments()
    {
        return $this->hasMany('App\Comment');
    }	
	
}
