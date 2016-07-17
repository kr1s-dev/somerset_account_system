@if (count($errors) > 0)
	<ul class="alert alert-danger">
		@foreach ($errors->all() as $error)
            <li align="center">{{ $error }}</li>
        @endforeach
	</ul>
@endif