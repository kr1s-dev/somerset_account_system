<div class="form-group" align="center">
	@include('errors.validator')
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
	<h4>All fields marked with * are required</h4>
</div>
@if($isCreate)
<div class="col-md-12 col-sm-12 col-xs-12">
 	<div class="x_panel">
    	<div class="x_title">
       		<h2>Create a New User from Existing Homeowner</h2>
       			<ul class="nav navbar-right panel_toolbox">
          			<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          			</li>
       			</ul>
       	<div class="clearfix"></div>
    	</div>
    	<div class="x_content">
       		<br>
         	<div class="form-group">
    			<label class="control-label col-md-3 col-sm-3 col-xs-12">Select Custom</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
  					<select name="home_owner_id" class="select2_single form-control" tabindex="-1" id="howeOwnersList">
    					<option></option>
    					@if(count($eHomeOwners))
	    					@foreach($eHomeOwners as $eHomeOwner)
	                        	<option value="{{$eHomeOwner->id}}" name="{{$eHomeOwner}}">
	                        		{{$eHomeOwner->first_name}} {{$eHomeOwner->middle_name}} {{$eHomeOwner->last_name}}
	                        	</option>
	                        @endforeach
                        @endif
  					</select>
				</div>
  			</div>
    	</div>
 	</div>
</div>
@elseif($nUser->home_owner_id != NULL)
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Associated HomeOwner
     	</label>
    <div class="col-md-9 col-sm-6 col-xs-12">
    	<input type="text" value="{{ $eHomeOwners[$nUser->home_owner_id]->first_name }} {{ $eHomeOwners[$nUser->home_owner_id]->middle_name }} {{ $eHomeOwners[$nUser->home_owner_id]->last_name }}" class="form-control col-md-7 col-xs-12" readonly>
    </div>
</div>
@endif
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
     	</label>
    <div class="col-md-9 col-sm-6 col-xs-12">
    	<input type="text" name="first_name" id="first_name" required="required" value="{{ $nUser->home_owner_id == NULL?(count($errors) > 0? old('first_name'):($nUser->first_name)):(count($errors) > 0?old('first_name'):$eHomeOwners[$nUser->home_owner_id]->first_name) }}" class="form-control col-md-7 col-xs-12">
    </div>
</div>
<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-6 col-xs-12">
		<input type="text" name="last_name" id="last_name" value="{{ $nUser->home_owner_id == NULL?(count($errors) > 0? old('last_name'):($nUser->last_name)):(count($errors) > 0?old('last_name'):$eHomeOwners[$nUser->home_owner_id]->last_name) }}" required="required" class="form-control col-md-7 col-xs-12">
	</div>
</div>

<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Middle Name / Initial <span class="required">*</span></label>
	<div class="col-md-9 col-sm-6 col-xs-12">
		<input name="middle_name" id="middle_name" class="form-control col-md-7 col-xs-12" value="{{ $nUser->home_owner_id == NULL?(count($errors) > 0? old('middle_name'):($nUser->middle_name)):(count($errors) > 0?old('middle_name'):$eHomeOwners[$nUser->home_owner_id]->middle_name) }}" type="text" name="middle-name">
	</div>
</div>
<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile Number <span class="required">*</span></label>
	<div class="col-md-9 col-sm-6 col-xs-12">
		<input id="mobile_number" class="form-control col-md-7 col-xs-12" value="{{ $nUser->home_owner_id == NULL?(count($errors) > 0? old('mobile_number'):($nUser->mobile_number)):(count($errors) > 0?old('mobile_number'):$eHomeOwners[$nUser->home_owner_id]->member_mobile_no) }}" type="text" name="mobile_number">
	</div>
</div>
<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
	<div class="col-md-9 col-sm-6 col-xs-12">
		<input id="email" class="form-control col-md-7 col-xs-12"value="{{ $nUser->home_owner_id == NULL?(count($errors) > 0? old('email'):($nUser->email)):(count($errors) > 0?old('email'):$eHomeOwners[$nUser->home_owner_id]->member_email_address) }}" type="text" name="email">
	</div>
</div>
<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">User Type</label>
	<div class="col-md-9 col-sm-6 col-xs-12">
		<select name="user_type_id" id="userType" class="form-control">
			@foreach($eUserTypesList as $key => $item)
				<option value="{{ $key }} ">{{ $item }}</option>
			@endforeach
		</select>
	</div>
</div>

<div class="ln_solid"></div>

<div class="form-group">
	<div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
		<a href="{{ route('users.index') }}" class="btn btn-primary">Cancel</a>
		@if($nUser->home_owner_id != NULL)
			<button type="submit" class="btn btn-success" onclick="return confirm('Updating this record will also update the information in associated Homeowner. Do you want to proceed?');">{{ $submitButton }}</button>
		@else
			<button type="submit" class="btn btn-success">{{ $submitButton }}</button>
		@endif
	</div>
</div>