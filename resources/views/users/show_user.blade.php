@extends('master_layout.master_page_layout')
@section('content')  
<div class="">
  	<div class="page-title">
  		<div class="title_left">
    		<h3><i class="fa fa-users"></i>Users</h3>
  		</div>
  	</div>
  	<div class="clearfix"></div>

  	<div class="col-md-12 col-sm-12 col-xs-12">
  		<div class="x_panel">
    		<div class="x_title">
           		<h2>
           			@if($eUser->home_owner_id != NULL)
           				{{$eUser->homeOwner->first_name}} 
           				{{$eUser->homeOwner->middle_name}}
           				{{$eUser->homeOwner->last_name}}
           			@else
           				{{$eUser->first_name}} 
           				{{$eUser->middle_name}}
           				{{$eUser->last_name}}
           			@endif
           		</h2>
           		<ul class="nav navbar-right panel_toolbox">
                  	<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  	</li>
           		</ul>
           		<div class="clearfix"></div>
    		</div>
    		<div class="x_content">
       			<!-- start accordion -->
	      		<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
	        		<div class="panel">
	          			<a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
	            			<h4 class="panel-title">Personal Information</h4>
	          			</a>
	          			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
	            			<div class="panel-body">
	                			<div class="actions">
	                   				<a href="{{ route('users.edit',$eUser->id) }}" class="btn btn-primary pull-right">
	                      				<i class="fa fa-pencil"></i> Edit
	                   				</a>
	                   				@if($eUser->is_active && $eUser->id != Auth::id())
	                   					<a href="{{ route('users.deactivateUser',$eUser->id) }}" class="btn btn-primary pull-right" onclick="return confirm('Are you sure you want to deactivate this user?');">
		                      				<i class="fa fa-lock"></i> Deactivate User
		                   				</a>
	                   				@endif

	                   				@if($eUser->id != Auth::id())
		                   				<a href="{{ route('users.resetpassword',$eUser->id) }}" class="btn btn-primary pull-right">
		                      				<i class="fa fa-key"></i> Reset Password
		                   				</a>
		                   			@else
		                   				<a href="{{ route('users.changepassword',$eUser->id) }}" class="btn btn-primary pull-right">
		                      				<i class="fa fa-key"></i> Change Password
		                   				</a>
		                   			@endif
	                   				
	                			</div>
	              				<table class="table table-bordered">
	                				<tbody>
	                   					<tr>
	                     		 			<td class="data-title"><strong>Last Name</strong></td>
	                      					<td>
	                      						@if($eUser->home_owner_id != NULL)
							           				{{$eUser->homeOwner->last_name}}
							           			@else
							           				{{$eUser->last_name}}
							           			@endif
	                      					</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>First Name</strong></td>
	                      					<td>
	                      						@if($eUser->home_owner_id != NULL)
							           				{{$eUser->homeOwner->first_name}}
							           			@else
							           				{{$eUser->first_name}}
							           			@endif
	                      					</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>Middle Name</strong></td>
	                      					<td>
	                      						@if($eUser->home_owner_id != NULL)
							           				{{$eUser->homeOwner->middle_name}}
							           			@else
							           				{{$eUser->middle_name}}
							           			@endif
	                      					</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>Mobile</strong></td>
	                      					<td>
	                      						@if($eUser->home_owner_id != NULL)
							           				{{$eUser->homeOwner->member_mobile_no}}
							           			@else
							           				{{$eUser->mobile_number}}
							           			@endif
	                      					</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>Email</strong></td>
	                      					<td>{{$eUser->email}}</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>Role</strong></td>
	                      					<td>{{$eUser->userType->type}}</td>
	                   					</tr>
	                				</tbody>
	              				</table>
	            			</div>
	          			</div>
	        		</div>
	        	</div>
	        </div>
      	</div>
      <!-- end of accordion -->
    </div>  
</div>
@endsection