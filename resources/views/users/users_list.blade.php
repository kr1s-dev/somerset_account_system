@extends('master_layout.master_page_layout')
@section('content')
	<div class="">
	    <div class="page-title">
	     	<div class="title_left">
	       		<h3><i class="fa fa-users"></i> Users</h3>
	      	</div>
	    </div>
	    <div class="clearfix"></div>

	    <div class="col-md-12 col-sm-12 col-xs-12">
	    	<div class="x_panel">
	      		<div class="x_title">
	        		<h2>List of All Users</h2>
	        		<ul class="nav navbar-right panel_toolbox">
	          			<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	          			</li>
	        		</ul>
	        		<div class="clearfix"></div>
	      		</div>
	      		<div class="x_content">
	        		<table id="datatable" class="table table-striped table-bordered">
	          			<thead>
	            			<tr>
	              				<th>Name</th>
	              				<th>User Type</th>
	              				<th>Mobile</th>
	              				<th>Email</th>
	              				<th>Date Created</th>
	              				<th>Is Active </th>
	              				<th>Actions</th>
	            			</tr>
	          			</thead>
	          			<tbody>
		          			@foreach($users_list as $user)
				          		<tr>
				          			@if($user->home_owner_id == NULL)
						          		<td><a href="{{ route('users.show',$user->id) }}"> {{ $user -> first_name }} {{ $user -> last_name }} </a></td>
						          		@if($user->user_type_id != NULL)
						          			<td align="center">{{ $user->userType->type }} </td>
						          		@else
						          			<td align="center"> - </td>
						          		@endif
						          		@if($user -> mobile_number != NULL)
						          			<td>{{ $user -> mobile_number }} </td>
						          		@else
						          			<td align="center"> - </td>
						          		@endif
						          		<td>{{ $user -> email }} </td>
						        	@else
						        		<td><a href="{{ route('users.show',$user->id) }}"> {{ $user->homeOwner->first_name }} {{ $user->homeOwner->last_name }} </a> </td>
						          		@if($user->user_type_id != NULL)
						          			<td align="center">{{ $user->userType->type }} </td>
						          		@else
						          			<td align="center"> - </td>
						          		@endif
						          		@if( $user->homeOwner->member_mobile_no != NULL)
						          			<td>{{ $user->homeOwner->member_mobile_no }} </td>
						          		@else
						          			<td align="center"> - </td>
						          		@endif
						          		<td>{{ $user->homeOwner->member_email_address }} </td>
				          			@endif
				          			<td>{{ date('F d, Y',strtotime($user -> created_at)) }} </td>
				          			<td>
				          				@if($user -> is_active )
				          					Yes
				          				@else
				          					No
				          				@endif
				          			</td>
				          			<td align="center">
						                <a href="{{ route('users.edit',$user->id) }}" role="button" class="btn btn-default">
						                <i class="fa fa-pencil"></i> 
						                </a>
						                @if(Auth::user()->id != $user->id)
						                	@if($user->is_active)
						                		{!! Form::model($user, ['method'=>'DELETE','action' => ['user\UserController@destroy',$user->id] , 'class' => 'form-horizontal form-label-left form-wrapper']) !!}
							                    	<button type="submit" class="btn btn-default" onclick="return confirm('Are you sure you want to lock this user?');"><i class="fa fa-lock"></i> </button>
							               		{!! Form::close() !!}
							               	@else
							               		<a href="{{route('users.resetpassword',$user->id)}}" class="btn btn-default"><i class="fa fa-unlock"></i></a>
						                	@endif
						               	@endif
						            </td>
				          		</tr>
				          	@endforeach
	          			</tbody>
	        		</table>
	      		</div>
	    	</div>
	  	</div>
	  	<div class="clearfix"></div>
	</div>
@endsection