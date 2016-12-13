<div class="container">

	<div class="col-sm-8 blog-main">
		@if($article)
			<div class="blog-post">
				<h2 class="blog-post-title"><a href="{{ route('article-show',['article'=>$article->id]) }}">{{ $article->title }}</a></h2>
				<div class="bs-callout bs-callout-info">
					@if($edit)
						<a class="btn btn-warning" href="{{route('article-edit', array('article'=>$article->id))}}" role="button">Edit Message</a>
					@endif
													
					@if($delete)
						<a class="btn btn-danger" href="{{route('article-delete', array('article'=>$article->id))}}" role="button">Delete Message</a>
					@endif
				</div>
												
	            <p class="blog-post-meta">
	                {{ $article->created_at->format('F d, Y') }}
	    			<span>by <a href="{{ (Auth::check() && $article->user->id == AUTH::user()->id) ? route('profile') : route('profile',array('id'=>$article->user->id))}}" title="Posts by {{ $article->user->fullname }}" rel="author">{{ $article->user->fullname }},</a></span>
	            	<span><a href="{{ route('article-show',['article'=>$article->id]) }}#respond">{{ count($article->comments) ? count($article->comments) : '0' }} {{ Lang::choice('ru.comments',count($article->comments)) }}</a></span>
	            </p>
	            
	            <div>
	                <img src="{{ asset(config('settings.theme')) }}/images/articles/{{ $article->img->max }}" />
	            </div>
	            <br />            

	        <p>
	            {!! $article->text !!}
	        </p>
	        <div class="clearfix"></div>
	    
	</div>
						            
	<!-- START COMMENTS -->
	<div id="comments">
	    <h3 id="comments-title">
	        <span>{{ count($article->comments) }}</span> {{ Lang::choice('ru.comments',count($article->comments)) }}    
	    </h3>

	    @if($article && count($article->comments) > 0)
		    @set($com,$article->comments->groupBy('parent_id'))
		    <ol class="commentlist group">
			    @foreach($com as $k => $comments)
			    	
			    	@if($k !== 0)
			    		@break
			    	@endif
			    	
			    	@include(config('settings.theme').'.comment',['items' => $comments])
			    	
			    @endforeach
		    </ol>
	    @endif


	    <div id="respond">
	        <h3 id="reply-title">Leave a <span>Reply</span> <small><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display:none;">Cancel</a></small></h3>
	        <form class="form-horizontal" action="{{ route('comment-store') }}" method="post" id="commentform">
	            @if(!Auth::check())
	                
	                <div class="form-group">
	                    <label for="name" class="col-md-4 control-label">Name</label>

	                    <div class="col-md-6">
	                        <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
	                    </div>
	                </div>
	                
	                <div class="form-group">
	                    <label for="email" class="col-md-4 control-label">Email</label>

	                    <div class="col-md-6">
	                        <input id="email" type="text" class="form-control" name="email" value="" required autofocus>
	                    </div>
	                </div>
	                
	                <div class="form-group">
	                    <label for="email" class="col-md-4 control-label">Website</label>

	                    <div class="col-md-6">
	                        <input id="url" type="text" class="form-control" name="site" value="" required autofocus>
	                    </div>
	                </div>

	            @endif
	            
	            <div class="form-group">
	            	<label for="comment" class="col-md-4 control-label">Your comment</label>
	            	<div class="col-md-6">
	            		<textarea class="form-control" id="comment" name="text" cols="45" rows="8"></textarea>
	            	</div>
	            </div>
	            <div class="clear"></div>
	
	            	{{ csrf_field() }}
	            	<input id="comment_post_ID" type="hidden" name="comment_post_ID" value="{{ $article->id }}" />
	            	<input id="comment_parent" type="hidden" name="comment_parent" value="0" />

	                <div class="form-group">
	                    <div class="col-md-8 col-md-offset-4">
	                        <button id="submit" name="submit" type="submit" class="btn btn-primary">
	                            Save
	                        </button>
	                    </div>
					 </div>
 
	        </form>
	    </div>
	    <!-- #respond -->
	</div>
			            <!-- END COMMENTS -->
				@else
				
					<h2>No message</h2>
				
				@endif
	</div>	  
         
</div>