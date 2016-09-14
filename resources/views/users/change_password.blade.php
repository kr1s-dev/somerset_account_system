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
               	<h2>Change Password</h2>
               	<ul class="nav navbar-right panel_toolbox">
                  	<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  	</li>
               	</ul>
               	<div class="clearfix"></div>
            </div>
            <div class="x_content">
            	{!! Form::open(['url'=>'users/changepassword','method'=>'POST','class'=>'form-horizontal form-label-left form-wrapper']) !!}
                  <div class="form-group" align="center">
                     @include('errors.validator')
                  </div>
                  <div class="form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Old Password <span class="required">*</span>
                     </label>
                     <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="password" name="old_password" id="last_name" required="required" class="form-control col-md-7 col-xs-12">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">New Password <span class="required">*</span>
                     </label>
                     <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="password" name="new_password" id="last_name" required="required" class="form-control col-md-7 col-xs-12">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">New Password Confirmation<span class="required">*</span>
                     </label>
                     <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="password" name="new_password_confirmation" id="last_name" required="required" class="form-control col-md-7 col-xs-12">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                        <a href="{{ route('users.show',$user->id) }}" class="btn btn-primary">Cancel</a>
                        <button type="submit" class="btn btn-success"> Submit </button>
                     </div>
                  </div>
            	{!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
@endsection
