
@if($users)	
	<div class="container-fluid">
		<h1>Users</h1>
		<table class="table table-striped">
			@foreach($users as $user)
				<tr>
					<td>
						
						@set($hash, md5($user->email))
				                                
				        <img alt="" src="https://www.gravatar.com/avatar/{{$hash}}?d=mm&s=75" class="avatar" height="75" width="75" />
                                                
						
					</td>
					<td><a href="{{ (Auth::check() && $user->id == AUTH::user()->id) ? route('profile') : route('profile',array('id'=>$user->id))}}">{{$user->fullname}}</a></td>
					<td>{{$user->email}}</td>
					<td>{{$user->city}}</td>
					<td>{{$user->country}}</td>
					
				</tr>
			@endforeach
		</table>
		
		<div class="pagination">
		{{ $users->links() }}
		</div>
	</div>
@else
	<div>Нет данных</div>
@endif