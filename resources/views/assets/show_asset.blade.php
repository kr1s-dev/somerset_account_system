@extends('master_layout.master_page_layout')
@section('content')
	<div class="">
	  	<div class="page-title">
	  		<div class="title_left">
	    		<h3><i class="fa fa-archive"></i> Assets</h3>
	  		</div>
	  	</div>
	  	<div class="clearfix"></div>

	  	<div class="col-md-12 col-sm-12 col-xs-12">
	  		<div class="x_panel">
	    		<div class="x_title">
	           		<h2>{{$assetModel->item_name}}</h2>
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
	            			<h4 class="panel-title">Asset Information</h4>
	          			</a>
	          			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
	            			<div class="panel-body">
	                			<div class="actions">
	                   				<a href="{{ route('assets.edit',$assetModel->id) }}" class="btn btn-primary pull-right">
	                      				<i class="fa fa-pencil"></i> Edit
	                   				</a>
	                			</div>
	              				<table class="table table-bordered">
	                				<tbody>
	                   					<tr>
	                     		 			<td class="data-title"><strong>Item Name</strong></td>
	                      					<td>{{$assetModel->item_name}}</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>Quantity</strong></td>
	                      					<td>{{$assetModel->quantity}}</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>Description</strong></td>
	                      					<td>{{$assetModel->description}}</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>Total Cost</strong></td>
	                      					<td>PHP {{number_format($assetModel->total_cost,2)}}</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>Salvage Value</strong></td>
	                      					<td>PHP {{number_format($assetModel->salvage_value,2)}}</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>Mode of Acquisition</strong></td>
	                      					<td>
	                      						@if($assetModel->mode_of_acquisition == 'Both')
	                      							Cash and Accounts Payable
	                      						@else
	                      							{{$assetModel->mode_of_acquisition}}
	                      						@endif
	                      					</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>Monthly Depreciation</strong></td>
	                      					<td>PHP {{number_format($assetModel->monthly_depreciation,2)}}</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>Month/s Remaining</strong></td>
	                      					<td>{{$assetModel->useful_life}}</td>
	                   					</tr>
	                   					<tr>
	                      					<td class="data-title"><strong>Current Net Market Value</strong></td>
	                      					<td>PHP {{number_format($assetModel->net_value,2)}}</td>
	                   					</tr>
	                   					<tr>
	                				</tbody>
	              				</table>
	            			</div>
	          			</div>
	        		</div>
	        	</div>
	   		</div>
	      <!-- end of accordion -->
	    </div>
	</div>
@endsection