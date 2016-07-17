if (count($errors) > 0)
	<ul class="alert alert-danger">
		@if($errors->has('g-recaptcha-response'))
			<strong>{{ $errors->first('g-recaptcha-response')}}</strong>
		@endif
	</ul>
@endif