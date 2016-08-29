@extends('master_layout.master_page_layout')
@section('content')
<div class="">
  	<div class="page-title">
     	<div class="title_left">
        	<h3><i class="fa fa-shopping-basket"></i> Vendors</h3>
     	</div>
  	</div>
  	<div class="clearfix"></div>
  	<div class="col-md-12 col-sm-12 col-xs-12">
     	<div class="x_panel">
        	<div class="x_title">
           		<h2>List of All Vendors</h2>
           		<ul class="nav navbar-right panel_toolbox">
              		<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              		</li>
           		</ul>
           		<div class="clearfix"></div>
        	</div>
        	<div class="x_content">
            	<div class="row">
                	<div class="col-md-12">
                    	<a href="{{route('vendor.create')}}" role="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Create New Vendor</a>
                	</div>
            	</div>
            	<br>
           		<table id="datatable" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
              		<thead>
	                 	<tr>
		                    <th>Vendor No.</th>
		                    <th style="width: 20%;">Vendor Name</th>
		                    <th>Description</th>
		                    <th>Mobile Number</th>
		                    <th>Telephone Number</th>
		                    <th>Email</th>
		                    <th style="width: 15%;">Contact Person</th>
		                    <th style="width: 10%;">Actions</th>
	                 	</tr>
              		</thead>
              		<tbody>
              			@foreach($vendorList as $vendor)
	              			<tr>
			                    <td><a href="{{route('vendor.show',$vendor->id)}}">#<strong>{{sprintf("%'.07d\n",$vendor->id)}}</strong></a></td>
			                    <td>{{$vendor->vendor_name}}</td>
			                    <td>{{$vendor->vendor_description}}</td>
			                    <td>{{$vendor->vendor_mobile_no}}</td>
			                    <td>{{$vendor->vendor_telephone_no}}</td>
			                    <td>{{$vendor->vendor_email_address}}</td>
			                    <td>{{$vendor->vendor_contact_person}}</td>
			                    <td align="center">
			                       <a href="{{route('vendor.edit',$vendor->id)}}" role="button" class="btn btn-default">
			                       <i class="fa fa-pencil"></i> 
			                       </a>
			                       {!! Form::model($vendor, ['method'=>'DELETE','action' => ['vendor\VendorController@destroy',$vendor->id] , 'class' => 'form-horizontal form-label-left  form-wrapper']) !!}
                        				<button type="submit" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </button>
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