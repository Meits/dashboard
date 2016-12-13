									
								@foreach($items as $item)	
									<li id="li-comment-{{ $item->id }}" class=" list-unstyled comment even {{ ($item->user_id == $article->user_id) ?  'bypostauthor odd' : ''}}">
				                        <div id="comment-{{ $item->id }}" class="comment-container">
				                            <div class="comment-author vcard">
                                                
                                                @set($hash, isset($item->email) ? md5($item->email) : md5($item->user->email))
				                                
				                                <img alt="" src="https://www.gravatar.com/avatar/{{$hash}}?d=mm&s=75" class="avatar" height="75" width="75" />
                                                
                                                <cite class="fn">{{ is_object($item->created_at) ? $article->created_at->format('F d, Y')  : ''}}, by {{$item->user->fullname or $item->fullname}}</cite>
												<div class="pull-right">
				                                    <div class="commentNumber">#&nbsp;</div>
				                                </div> 
												<div class="clearfix"></div>                
				                            </div>
				                            
				                            <div class="comment-meta commentmetadata">
				                                <div class="comment-body">
				                                    {{$item->text}}
				                                </div>
				                                <div class="bs-callout bs-callout-info">
				                                    <a class="comment-reply-link  btn btn-primary btn-sm" href="#respond" onclick="return addComment.moveForm(&quot;comment-{{$item->id}}&quot;, &quot;{{$item->id}}&quot;, &quot;respond&quot;, &quot;{{$item->article_id}}&quot;)">Reply</a>                    
				                                    
				                                    @if(Auth::check() && Gate::allows('edit',$item))
				                                    	<a class="comment-edit-link btn btn-warning btn-sm" href="#respond" onclick="return EditComment(&quot;comment-{{$item->id}}&quot;, &quot;{{$item->id}}&quot;, &quot;respond&quot;, &quot;{{$item->article_id}}&quot;)">Edit</a>                    
				                                    @endif
				                                    
				                                     @if(Auth::check() && Gate::allows('destroy',$item))
				                                    	<a class="comment-delete-link btn btn-danger btn-sm" href="{{route('comment-delete',array('comment'=>$item->id))}}">DELETE</a>  
				                                    @endif
				                                                      
				                                </div>
				                                <!-- .reply -->
				                            </div>
				                           
				                        </div>
				                        
				                    	
				                    	@if(isset($com[$item->id]))
				                    		<ul class="children">
				                    			@include(config('settings.theme').'.comment',['items'=>$com[$item->id]])
				                    		</ul>
				                    	@endif
				                    
				                    </li>
				                   
				                  
				                  @endforeach  