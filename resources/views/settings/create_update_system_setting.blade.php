@extends('master_layout.master_page_layout')
@section('content')
	<div class="">
      	<div class="page-title">
         	<div class="title_left">
            	<h3><i class="fa fa-cog"></i> Settings</h3>
         	</div>
      	</div>
      	<div class="clearfix"></div>
      	<div class="col-md-12 col-sm-12 col-xs-12">
         	<div class="x_panel">
	            <div class="x_title">
	               	<h2>Update Settings</h2>
	               		<ul class="nav navbar-right panel_toolbox">
	                  		<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	                  		</li>
	               		</ul>
	               <div class="clearfix"></div>
	            </div>
	            <div class="x_content">
	            	@if($setting->id == NULL)
	            		{!! Form::open(['url'=>'settings','method'=>'POST','class'=>'form-horizontal form-label-left']) !!}
	            	@else
	            		{!! Form::model($setting, ['method'=>'PATCH','action' => ['settings\SettingsController@update',$setting->id] , 'class' => 'form-horizontal form-label-left']) !!}
	            	@endif
						<div class="form-group" align="center">
						  @include('errors.validator')
						</div>
	                  	<div class="form-group">
	                     	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tax (%)
	                     	</label>
	                     	<div class="col-md-2 col-sm-6 col-xs-12">
	                        	<input type="number" name="tax" min="1" id="tax" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('tax'):($setting->tax) }}" >
	                     	</div>
	                 	 </div>

	                  	<div class="form-group">
	                     	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Number of days for due date
	                     	</label>
	                     	<div class="col-md-2 col-sm-6 col-xs-12">
	                        	<input type="number" min="1" name="days_till_due_date" id="tax" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('days_till_due_date'):($setting->days_till_due_date) }}" >
	                     	</div>
	                  	</div>
	                  
	                  	<div class="form-group">
	                     	<label class="control-label col-md-3 col-sm-3 col-xs-12">Cut-off Date (Per Month)<span class="required">*</span>
	                     	</label>
	                     	<div class="col-md-2 col-sm-4 col-xs-12">
	                        	<input id="fiscal-year-start" name="cut_off_date" min="1" max="30" class="form-control col-md-7 col-xs-12" required="required" type="number" value="{{ count($errors) > 0? old('cut_off_date'):($setting->cut_off_date) }}" >
	                     	</div>
	                  	</div>
	                  	<div class="form-group">
  							<div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
							    <button type="submit" onclick="goBack();" class="btn btn-primary">Cancel</button>
							    <script type="text/javascript">
							    	function goBack() {
								        window.history.back();
								    }
							    </script>
							    <button type="submit" class="btn btn-success">Submit</button>
							</div>
						</div>
	               	{!! Form::close() !!}
	            </div>
        	</div>
      	</div>
   </div>
@endsection