@extends('master_layout.master_page_layout')
@section('content')
	<div class="">
      	<div class="page-title">
         	<div class="title_left">
            	<h3><i class="fa fa-home"></i> Settings</h3>
         	</div>
      	</div>
      	<div class="clearfix"></div>
      	<div class="col-md-12 col-sm-12 col-xs-12">
         	<div class="x_panel">
	            <div class="x_title">
	               	<h2>Settings Information</h2>
	               		<ul class="nav navbar-right panel_toolbox">
	                  		<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	                  		</li>
	               		</ul>
	               <div class="clearfix"></div>
	            </div>
	            <div class="x_content">
	            	<div class="actions">
           				<a href="{{ route('settings.create') }}" class="btn btn-primary pull-right">
              				<i class="fa fa-pencil"></i> Edit
           				</a>
        			</div>
	            	<table class="table table-bordered">
	            		<tbody>
	                        <tr>
	                          <td class="data-title"><strong>Tax</strong></td>
	                            <td>{{$setting->tax}}</td>
	                        </tr>
	                        <tr>
	                          <td class="data-title"><strong>Number of Days for Due Date:</strong></td>
	                            <td>{{$setting->days_till_due_date}}</td>
	                        </tr>
	                        <tr>
	                          <td class="data-title"><strong>Cut off Date:</strong></td>
	                            <td>{{$setting->cut_off_date}}</td>
	                        </tr>
            			</tbody>
          			</table>
	            </div>
        	</div>
      	</div>
   </div>
@endsection