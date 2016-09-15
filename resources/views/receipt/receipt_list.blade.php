@extends('master_layout.master_page_layout')
@section('content')
<!-- page content -->
    <div class="">
        <div class="page-title">
          	<div class="title_left">
            	<h3><i class="fa fa-money"></i> Receipts</h3>
          	</div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
	        <div class="x_panel">
	          	<div class="x_title">
	            	<h2>List of All Receipts</h2>
	            	<ul class="nav navbar-right panel_toolbox">
	              		<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	              		</li>
	            	</ul>
	            	<div class="clearfix"></div>
	          	</div>
	          	<div class="x_content">
	            	<table id="datatable" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
		              	<thead>
		                	<tr>
		                  		<th>Receipt #</th>
		                  		<th>Invoice #</th>
		                  		<th>To</th>
		                  		<th>Payment Due</th>
		                  		<th>Paid Date</th>
		                  		<th>Amount Due</th>	
		                	</tr>
		              	</thead>
		              	<tbody>
	                		@foreach($eHomeOwnerReceiptList as $eHomeOwnerReceipt)
	                			<tr>
	                				<td><a href="{{route('receipt.show',$eHomeOwnerReceipt->id)}}"><strong>#{{sprintf("%'.07d\n",$eHomeOwnerReceipt->receipt_no)}}</strong></a></td>
	                				<td><a href="{{ route('invoice.show',$eHomeOwnerReceipt->payment_id) }}"><strong>#{{sprintf("%'.07d\n",$eHomeOwnerReceipt->invoice->id)}}</strong></a></td>
	                				<td>{{$eHomeOwnerReceipt->invoice->homeOwner->first_name}}
		                				{{$eHomeOwnerReceipt->invoice->homeOwner->middle_name}}
		                				{{$eHomeOwnerReceipt->invoice->homeOwner->last_name}}
	                				</td>
	                				<td>{{date('F d, Y',strtotime($eHomeOwnerReceipt->invoice->payment_due_date))}}</td>
	                				<td>{{date_format($eHomeOwnerReceipt->created_at,'F d, Y')}}</td>
	                				<td>{{number_format($eHomeOwnerReceipt->invoice->total_amount,2)}}</td>
	                			</tr>
	                		@endforeach
	     		        </tbody>
	            	</table>
	          	</div>
	          	<div class="clearfix"></div>
	        </div>
	    </div>
    </div>
<!-- /page content -->
@endsection