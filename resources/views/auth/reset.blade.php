@extends('master_layout.master_auth_layout')
@section('content')
	<div>
		<div>
	      	<a class="hiddenanchor" id="signup"></a>
	      	<a class="hiddenanchor" id="signin"></a>
	      	<div class="login_wrapper">
	        	<div class="animate form login_form">
	          		<section class="login_content">
	            		{!! Form::open(['url'=>'password/reset','method'=>'POST']) !!}
	              			<h1>Forgot Password</h1>
	              			@include('flash::message');
	              			@include('errors.validator')
	              			<input type="hidden" name="token" value="{{ $token }}">
	              			<div>
	                			<input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}"/>
	              			</div>
	              			<div>
                				<input type="password" class="form-control" name="password" placeholder="Password"/>
              				</div>
              				<div>
                				<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"/>
              				</div>
	              			<div>
	              				<input type="submit" class="btn btn-default pull-right submit" value="Submit">
	              			</div>
	              			<div class="clearfix"></div>

	              			<div class="separator">
	                			<div>
	                  				<h1><i class="fa fa-home"></i> Somerset Place Accounting System</h1>
	                  				<p>©2016 All Rights Reserved. </p>
	                			</div>
	              			</div>
	            		{!! Form::close() !!}
	          		</section>
	        	</div>
	      	</div>
	    </div>
	</div>
@endsection