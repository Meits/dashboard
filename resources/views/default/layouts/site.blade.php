<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
   
  
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset(config('settings.theme').'/favicon.ico')}}">

    <title>{{$title or 'Page'}}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset(config('settings.theme').'/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset(config('settings.theme').'/css/style.css')}}" rel="stylesheet">
    <link href="{{asset(config('settings.theme').'/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    
    
    <script src="{{asset(config('settings.theme').'/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset(config('settings.theme').'/js/moment.js')}}"></script>
    <script src="{{asset(config('settings.theme').'/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset(config('settings.theme').'/js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset(config('settings.theme').'/js/bootstrap-filestyle.min.js')}}"></script>
    <script src="{{asset(config('settings.theme').'/js/comment-reply.js')}}"></script>
	
	<script src="{{asset(config('settings.theme').'/js/script.js')}}"></script>
	

    
  </head>

  <body>

    <div class="container">
<div class="wrap_result"></div>
      <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <div class="masthead">
        <h3 class="text-muted">Project name</h3>
        <nav>
          @yield('navigation')
        </nav>
      </div>

      <!-- Jumbotron -->
      <!--<div class="jumbotron">
        <h1>Marketing stuff!</h1>
        <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet.</p>
        <p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p>
      </div>-->

      <!-- Example row of columns -->
      <div class="row">
      
      
      			@if (isset($errors) && count($errors) > 0)
				    <div style="padding:10px" class="bg-danger">
				        
				            @foreach ($errors->all() as $error)
				                <p>{{ $error }}</p>
				            @endforeach
				   
				    </div>
				@endif
				
				@if (session('status'))
				    <div style="padding:10px" class="bg-success">
				        {{ session('status') }}
				    </div>
				@endif
				
				@if (session('error'))
				    <div style="padding:10px" class="bg-danger">
				        {{ session('error') }}
				    </div>
				@endif
				
				
       @yield('content')
      </div>

      @yield('footer')

    </div> <!-- /container -->

  </body>
</html>
