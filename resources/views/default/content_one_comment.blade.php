<li id="li-comment-{{$data['id']}}" class="comment even list-unstyled">
	<div id="comment-{{$data['id']}}" class="comment-container">
		<div class="comment-author vcard">			                                
			<img alt="" src="https://www.gravatar.com/avatar/{{$data['hash']}}?d=mm&s=75" class="avatar" height="75" width="75" />
		    <cite class="fn">{{$data['created_at']}}, by {{$data['name']}}</cite> 
			
			<div class="pull-right">
				                                    <div class="commentNumber">#&nbsp;</div>
				                                </div> 
												<div class="clearfix"></div>                
		</div>
						                            
		<div class="comment-meta commentmetadata">
			<div class="comment-body">
				<p>{{$data['text']}}</p>
			</div>
			<div class="bs-callout bs-callout-info">
				<a class="comment-reply-link btn btn-primary btn-sm" href="#respond" onclick="return addComment.moveForm(&quot;comment-{{$data['id']}}&quot;, &quot;{{$data['id']}}&quot;, &quot;respond&quot;, &quot;{{$data['article_id']}}&quot;)">Reply</a>                    
				@if($data['edit_delete'])
					<a class="comment-edit-link btn btn-warning btn-sm" href="#respond" onclick="return EditComment(&quot;comment-{{$data['id']}}&quot;, &quot;{{$data['id']}}&quot;, &quot;respond&quot;, &quot;{{$data['article_id']}}&quot;)">Edit</a>                    
					<a class="comment-delete-link btn btn-danger btn-sm" href="{{route('comment-delete',array('comment'=>$data['id']))}}">DELETE</a>                    
				@endif
				</div>
		</div>		                           
	</div>
</li>