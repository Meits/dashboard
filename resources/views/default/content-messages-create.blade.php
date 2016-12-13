<h1>{{isset($article) ? 'Edit message - '.$article->title : 'Add message'}}</h1>

<div id="content-page" class="container-fluid">
<div class="hentry group">
{!! Form::open(['url' => (isset($article->id)) ? route('article-update',['article'=>$article->id]) : route('article-store'),'class'=>'form-horizontal','method'=>'POST','enctype'=>'multipart/form-data']) !!}
		<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
			<label for="title" class="col-md-4 control-label">Title</label>
			<div class="col-md-6">
				{!! Form::text('title',isset($article->title) ? $article->title  : old('title'), ['placeholder'=>'Введите название страницы','class'=>'form-control']) !!}
			 	@if ($errors->has('title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                 @endif
			 </div>
		 </div>
		 
		
		<div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
			<label for="text" class="col-md-4 control-label">Text</label>
			
			<div class="col-md-6">
			{!! Form::textarea('text', isset($article->text) ? $article->text  : old('text'), ['id'=>'editor2','class' => 'form-control','placeholder'=>'Введите текст страницы']) !!}
			@if ($errors->has('text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                     @endif
			
			</div>
			<div class="msg-error"></div>
		</div>
		
		@if(isset($article->img->path))
			<div class="form-group">
				
				<label for="image" class="col-md-4 control-label">Previous image</label>
				<div class="col-md-6">
				
				{{ Html::image(asset(config('settings.theme')).'/images/articles/'.$article->img->mini,'') }}
				{!! Form::hidden('old_image',$article->img->path) !!}
			 </div>
			</div>	
		@endif
		
		
		<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
			<label for="image" class="col-md-4 control-label">Image</label>
			
			
			<div class="col-md-6">
				{!! Form::file('image', ['class' => 'filestyle form-control','data-buttonText'=>'Выберите изображение','data-buttonName'=>"btn-primary",'data-placeholder'=>"Файла нет"]) !!}
			 </div>
			 
		</div> 

		
		<div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                   Save
                                </button>
                            </div>
                        </div>	
		 
	
    
    
    
    
{!! Form::close() !!}

 <script>
	CKEDITOR.replace( 'editor2' );
</script>
</div>
</div>