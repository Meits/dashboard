<h2 class="blog-post-title">Search</h2>

{!! Form::open(array('url' => '/search', 'class'=>'form-horizontal')) !!}
	
	<div class="form-group">
		<label for="inputEmail3">By text</label>
	    {!! Form::text('search_text', session('text') ? session('text') : '',
	                           array(
	                                'class'=>'form-control',
	                                'placeholder'=>'Search for a tutorial...')) !!}
	</div>
	
	<div class="form-group">
		<label for="inputEmail3">By city</label>
	    {!! Form::select('city', $cyties,session('city') ? session('city') : '',['class'=>'form-control']) !!}
	</div>
	
	<div class="form-group">
		<label for="inputEmail3">By author</label>
	    <div class="input-prepend">
				{!! Form::select('user_id', $users,session('user') ? session('user') : '',['class'=>'form-control']) !!}
			 </div>
	</div>							
     {!! Form::submit('Search',
                                array('class'=>'btn btn-default')) !!}
 {!! Form::close() !!}