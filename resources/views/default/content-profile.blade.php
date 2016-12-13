
@if($user && is_array($user))

	<h1>{{(Auth::check() && ($user['id'] == Auth::user()->id)) ? 'Welcome' : 'User'}}  - {{$user['fullname']}}</h1>	
	
	
	<div class="col-md-6">
	<table class="table table-striped">
	
		<tr>
			<td>@set($hash, md5($user['email']))                             
				<img alt="" src="https://www.gravatar.com/avatar/{{$hash}}?d=mm&s=75" class="avatar" height="75" width="75" />
			</td>
			<td>
			
			</td>
		</tr>
	@foreach($user as $key=>$value)
		<tr>
			<td>{{$key}}</td>
			<td>{{$value}}</td>
		</tr>
	@endforeach
	</table>
	</div>
	<div class="col-md-6">
		<div id="map_canvas"></div>
		<script>
			
			$.ajax({
			    type: "GET",
			    url: "https://maps.googleapis.com/maps/api/geocode/json?address={{$user['address']}}+{{$user['city']}},+{{$user['state']}},+{{$user['country']}}&key=AIzaSyAmSOmgembVTsNnywCtrAvW-qf_5eULvJM&callback",
			    dataType: "json",
			    success: function (json) {
					console.log(json);
					if(json.status == "ZERO_RESULTS") {
						document.getElementById('map_canvas').innerHTML = '<H2>Wrong Address user</H2>';
						return false;
					}
					var lat = json.results[0].geometry.location.lat;
					var lng = json.results[0].geometry.location.lng;
					
					// 
					 var map = new google.maps.Map(document.getElementById('map_canvas'), {
			          center: {lat: lat, lng: lng},
			          scrollwheel: false,
			          zoom: 15
			        });

					var marker = new google.maps.Marker({
					    position: {lat: lat, lng: lng},
					    map: map,
					    title: "{{$user['fullname']}}"
					  });

					
				}
			  });
			
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmSOmgembVTsNnywCtrAvW-qf_5eULvJM"
    async defer></script>
	</div>
	
	<div class="clearfix"></div>
	
	<div class="container">
		@if($edit)
			<a class="btn btn-warning" href="{{route('users_edit', array('user'=>$user['id']))}}" role="button">Edit User</a>
		@endif
		
		@if($delete)
			<a class="btn btn-danger" href="{{route('users_delete', array('user'=>$user['id']))}}" role="button">Delete User</a>
		@endif
		
		@if(Auth::check() && ($user['id'] == Auth::user()->id))
		<form style="margin-right:30px" class="pull-left" action="{{route('logout')}}" method="POST">
			 {{ csrf_field() }}
			<button class="btn btn-success" type="submit">LogOut</button>
		</form>	
		@endif
		
	</div>
	
@else
	<h2>No user</h2>
@endif