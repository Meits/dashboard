<?php

namespace App\Repositories;

use App\Comment;
use Config;

class CommentsRepository extends Repository
{
	
    public function __construct(Comment $comment) {
		$this->model  = $comment;
	}
    
}