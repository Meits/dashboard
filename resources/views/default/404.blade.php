@extends(config('settings.theme').'.layouts.site')

@section('content')
	<div id="content-index" class="container">
				            <h2>Not Found</h2>
							<div class="p">
				                <p>We are sorry but the page you are looking for does not exist.<br />You could <a href="{{route('home')}}">return to the home page</a> or search using the search box below.</p> 
				            </div>
				        </div>
@endsection 

@section('footer')
	@include(config('settings.theme').'.footer')
@endsection 