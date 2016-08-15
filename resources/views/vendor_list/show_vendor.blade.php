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
	               	<h2>{{$vendor->vendor_name}}</h2>
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
	                    		<h4 class="panel-title">Vendor Information</h4>
	                  		</a>
                  			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    			<div class="panel-body">
                        			<div class="actions">
                           				<a href="{{route('vendor.edit',$vendor->id)}}" class="btn btn-primary pull-right">
                              				<i class="fa fa-pencil"></i> Edit
                           				</a>
                        			</div>
                      				<table class="table table-bordered">
				                        <tbody>
				                           <tr>
				                              <td class="data-title"><strong>Vendor No.</strong></td>
				                              <td>{{sprintf("%'.07d\n",$vendor->id)}}</td>
				                           </tr>
				                           <tr>
				                              <td class="data-title"><strong>Description</strong></td>
				                              <td>{{$vendor->vendor_description}}</td>
				                           </tr>
				                           <tr>
				                              <td class="data-title"><strong>Mobile No.</strong></td>
				                              <td>{{$vendor->vendor_mobile_no}}</td>
				                           </tr>
				                           <tr>
				                              <td class="data-title"><strong>Tel No.</strong></td>
				                              <td>{{$vendor->vendor_telephone_no}}</td>
				                           </tr>
				                           <tr>
				                              <td class="data-title"><strong>Email</strong></td>
				                              <td>{{$vendor->vendor_email_address}}</td>
				                           </tr>
				                           <tr>
				                              <td class="data-title"><strong>Contact Person</strong></td>
				                              <td>{{$vendor->vendor_contact_person}}</td>
				                           </tr>
				                        </tbody>
                      				</table>
                    			</div>
                  			</div>
                		</div>
              		</div>
              		<!-- end of accordion -->
            	</div>
         	</div>
      	</div>
   	</div>
@endsection