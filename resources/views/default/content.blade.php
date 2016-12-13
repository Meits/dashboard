<div class="container">
	<div class="col-sm-8 blog-main">
		@if(isset($articles) && $articles && $articles->count() > 0)		            
			@foreach($articles as $article)
				<div class="blog-post">
					<h2 class="blog-post-title">
						<a href="{{ route('article-show',['article'=>$article->id]) }}">{{ $article->title }}</a>
					</h2>
					<div class="blog-post-meta">
						{{ $article->created_at->format('F d, Y') }}
						<span>by <a href="{{ (Auth::check() && $article->user->id == AUTH::user()->id) ? route('profile') : route('profile',array('id'=>$article->user->id))}}" title="Posts by {{ $article->user->fullname }}" rel="author">{{ $article->user->fullname }},</a></span>
						<span><a href="{{ route('article-show',['article'=>$article->id]) }}#respond">{{ count($article->comments) ? count($article->comments) : '0' }} {{ Lang::choice('ru.comments',count($article->comments)) }}</a></span>
					</div>
							                    
					<div class="pull-left" style="margin-right:20px;">
						<img src="{{ asset(config('settings.theme')) }}/images/articles/{{ $article->img->mini }}" />
					</div>            
			
					<p>
						{!! $article->text !!}
					</p>	
					<p><a href="{{ route('article-show',['article' => $article->id]) }}" class="btn   btn-beetle-bus-goes-jamba-juice-4 btn-more-link">> {{ Lang::get('ru.read_more') }}</a></p>
							            
				</div>
				
				<div class="clearfix"></div>
			@endforeach
			<div class="pagination">
				{{ $articles->links() }}
			</div>
		@else
			{!! Lang::get('ru.articles_no') !!}
		@endif
	</div>	  
	<div class="col-sm-4">
		@if(isset($sideBar) && !empty($sideBar)) 
			{!! $sideBar !!}
		@endif
	</div>          
</div>