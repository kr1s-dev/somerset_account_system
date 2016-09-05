@extends('master_layout.master_page_layout')
@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="">
    	
    	<div class="row">
    		<div class="col-md-12">
				<div class="page-title col-md-12">
		            <h3><i class="fa fa-file-text"></i> Somerset 
		            	Statement of Cash Flow
		            	For the Year Ended {{date('M t',strtotime($yearFilter . '-'. '12'))}}, {{$yearFilter}}</h3>
		        </div>
			</div>
    	</div>
        <div class="clearfix"></div>

        <div class="col-md-12 col-sm-12 col-xs-12">
	        <div class="x_panel">
			    <div class="row">
		    		
		    		<div class="col-md-12">
		    			<div class="pull-right">
			        	</div>
		    		</div>
		    	</div>
		    	<br>
	        	<div class="row">
	        		<div class="col-md-12">
	        			<table class="table table-striped table-bordered">
			              	<thead>
				                <tr>
				                  	<th colspan="3"><h3>Cash Flow from Operating Activities</h3></th>
				                </tr>
			              	</thead>
			              	<tbody>
			              		<tr>
			              			<td colspan="2">Cash Received from Customers </td>
			              			<td align="right"> ₱ {{number_format($incTotalSum-$arBalance,2)}}</td>
			              		</tr>
			              		@if(count($expenseList)>0)
			              			<tr>
			              				<td colspan="3">Cash Payments For: </td>
				              		</tr>
				              		@foreach($expenseList as $key=>$value)
				              			@if($value > 0)
				              				<tr>
					              				<td>{{str_replace(strpos($key, 'Expense')?'Expense':'Expenses', '', $key)}}</td>
					              				<td align="right">₱ {{number_format($value,2)}}</td>
					              				<td></td>
					              			</tr>
				              			@endif
				              		@endforeach
			              		@endif
			              		
			              	</tbody>
			              	<thead>
				                <tr>
				                  	<th colspan="3"><h3>Cash Flow from Investing Activities</h3></th>
				                </tr>
			              	</thead>
			              	<tbody>
			              		@if(count($investmentList)<=0)
			              			<tr>
			              				<td colspan="3" align="center"><i><strong>No Activity Found</strong></i></td>
			              			</tr>
			              		@else
			              			@foreach($investmentList as $key => $value)
				              			@if($value != 0)
				              				<tr>
					              				<td>Acquisition of {{$key}}</td>
					              				<td align="right">₱ {{number_format($value,2)}}</td>
					              				<td></td>
					              			</tr>
				              			@endif
				              		@endforeach
			              		@endif
			              	</tbody>
			              	<thead>
				                <tr>
				                  	<th colspan="3"><h3>Cash Flow from Financing Activities</h3></th>
				                </tr>
			              	</thead>
			              	<tbody>
			              		@if(count($financingList)<=0)
			              			<tr>
			              				<td colspan="3" align="center"><i><strong>No Activity Found</strong></i></td>
			              			</tr>
			              		@else
			              			@foreach($financingList as $key => $value)
				              			@if($value != 0)
				              				<tr>
					              				<td colspan="2">{{$key}}</td>
					              				<td align="right">₱ {{number_format($value,2)}}</td>
					              			</tr>
				              			@endif
				              		@endforeach
			              		@endif
			              	</tbody>
			              	<thead>
				                <tr>
				                  	<td colspan="2"><h3>Total Cash In Hand</h3></td>
				                  	<td align="right">₱ {{number_format($totalCashInHand,2)}}</td>
				                </tr>
			              	</thead>
			            </table>
	        		</div>
	        	</div>
        		<div class="pull-right">
        			
        		</div>
        		<div style="margin-top:50px">
        			{!! Form::open(['url'=>'pdf','method'=>'POST','target'=>'_blank']) !!}
	                    @include('pdf.pdf_form',['category'=>'statement_of_cash_flow_report',
	                    							'recordId'=>null,
	                    							'month_filter'=>null,
	                    							'year_filter'=>$yearFilter])
	                {!! Form::close() !!}
        		</div>
          	</div>
	    </div>
	</div>
@endsection