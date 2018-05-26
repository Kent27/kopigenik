@if($errors->any())
	<div class="alert alert-danger" style="position: fixed; bottom: 0; right: 5px;">
		<ul>
		@foreach($errors->all() as $error)
			<li>{{$error}}</li>
		@endforeach
		</ul>
	</div>
@endif