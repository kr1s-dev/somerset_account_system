@extends('master_layout.master_auth_layout')
@section('content')
	<div>
		<div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-3" style="margin-top: 5%;">
	        <div class="animate form login_form">
	          	<section class="login_content">
	            {!! Form::open(['url'=>'settings','method'=>'POST','class'=>'form-horizontal form-label-left']) !!}
	              	<h1>System Settings</h1>
	              	<div class="form-group">
	                 	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tax (%)
	                 	</label>
	                 	<div class="col-md-8 col-sm-8 col-xs-12">
	                    	<input type="number" name="tax" min="1" max="100" id="tax" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('tax'):($setting->tax) }}" >
	                 	</div>
             	 	</div>

	              	<div class="form-group">
	                 	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Number of days for due date
	                 	</label>
	                 	<div class="col-md-8 col-sm-8 col-xs-12">
	                    	<input type="number" min="1" max="9999" name="days_till_due_date" id="tax" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('days_till_due_date'):($setting->days_till_due_date) }}" >
	                 	</div>
	              	</div>
              
	              	<div class="form-group">
	                 	<label class="control-label col-md-3 col-sm-3 col-xs-12">Cut-off Date (Per Month)<span class="required">*</span>
	                 	</label>
	                 	<div class="col-md-8 col-sm-8 col-xs-12">
	                    	<input id="fiscal-year-start" name="cut_off_date" min="1" max="30" class="form-control col-md-7 col-xs-12" required="required" type="number" value="{{ count($errors) > 0? old('cut_off_date'):($setting->cut_off_date) }}" >
	                 	</div>
	              	</div>
	              	<div class="form-group">
	              		<div class="pull-right" style="margin-right:9%">
	              			<button type="submit" class="btn btn-success">Submit</button>
	              		</div>
	              		
	              	</div>

	                <div class="clearfix"></div>
	                <br />

	                <div>
	                  <h2><i class="fa fa-home"></i> Somerset Place Accounting System</h2>
	                  <p>©2016 All Rights Reserved. </p>
	                </div>
	              </div>
	            {!! Form::close() !!}
	          </section>
	        </div>
	    </div>
	</div>
@endsection