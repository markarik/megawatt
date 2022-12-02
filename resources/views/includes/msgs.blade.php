@if( Session::has('msg') && Session::get('msg') )
	<div class="alert alert-success">
		<div>
			{{ Session::get('msg') }}
		</div>
	</div>
@endif
