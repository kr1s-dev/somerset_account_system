@extends('master_layout.master_page_layout')
@section('content')
  	<div class="">
    	<div class="page-title">
      		<div class="title_left">
        		<h3><i class="fa fa-home"></i> Homeowners</h3>
      		</div>
    	</div>
    	<div class="clearfix"></div>
    	<div class="col-md-12 col-sm-12 col-xs-12">
    		<div class="x_panel">
      			<div class="x_title">
        			<h2>List of All Homeowners</h2>
        			<ul class="nav navbar-right panel_toolbox">
          				<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          				</li>
        			</ul>
        			<div class="clearfix"></div>
      			</div>
      			<div class="x_content">
	        		<table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	          			<thead>
	            			<tr>
	              				<th>Name</th>
	              				<th>Address</th>
	              				<th>Phone</th>
	              				<th>Mobile</th>
	              				<th>Email</th>
	              				<th>Actions</th>
	            			</tr>
	          			</thead>
	          			<tbody>
	          				@foreach($eHomeOwnersList as $eHomeOwners)
	          					<tr>
	          						<td><a href="{{ route('homeowners.show',$eHomeOwners->id) }}"><strong>{{ $eHomeOwners->first_name }} {{ $eHomeOwners->middle_name }} {{ $eHomeOwners->last_name }}</strong></a></td>
	          						<td>{{ $eHomeOwners->member_address }}</td>
	          						<td>{{ $eHomeOwners->residence_tel_no }}</td>
	          						<td>{{ $eHomeOwners->member_mobile_no }}</td>
	          						<td>{{ $eHomeOwners->member_email_address }}</td>
	          						<td align="center">
		                				<a href="{{ route('homeowners.edit',$eHomeOwners->id) }}" role="button" class="btn btn-default">
		                					<i class="fa fa-pencil"></i> 
		                				</a>
		                				{!! Form::model($eHomeOwners, ['method'=>'DELETE','action' => ['homeownerinformation\HomeOwnerInformationController@destroy',$eHomeOwners->id] , 'class' => 'form-horizontal form-label-left']) !!}
						                    <button type="submit" class="btn btn-default"><i class="fa fa-trash" onclick="return confirm('Are you sure you want to delete this item?');"></i> </button>
						               	{!! Form::close() !!}
		              				</td>
	          					</tr>
	          				@endforeach
	            			
	          			</tbody>
	        		</table>
      			</div>
      			<div class="clearfix"></div>
      		</div>
    	</div>
  	</div>
@endsection