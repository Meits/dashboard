@if($menu)
	<ul class="nav nav-justified">
		@include(config('settings.theme').'.customMenuItems',['items'=>$menu->roots()])
	</ul>
@endif