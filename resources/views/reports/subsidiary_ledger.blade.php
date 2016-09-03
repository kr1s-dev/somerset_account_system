@extends('master_layout.master_page_layout')
@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="">
    	
    	<div class="row">
    		<div class="col-md-12">
				<div class="page-title">
		            <h3><i class="fa fa-file-text"></i> Subsidiary Ledger for period 
		            	@if(!empty($monthFilter))
		            		{{$monthArray[$monthFilter]}}, 
		            	@endif 
		            	{{$yearFilter}}</h3>
		        </div>
			</div>
    	</div>
        <div class="clearfix"></div>

        <div class="col-md-12 col-sm-12 col-xs-12">
	        <div class="x_panel">
			    <div class="row">
		    		
		    		<div class="col-md-12">
		    			<div class="pull-right">
		    				
		    				{!! Form::open(['url'=>'reports/subledger','method'=>'POST']) !!}
		    					<select name="month_filter" class="select2_single form-control" tabindex="-1" id="howeOwnersList">
				        			<option></option>
			    					@foreach(range(1,12) as $month)
			    						<option value="{{$month}}">{{date('F',strtotime(date('Y').'-'.$month))}}</option>
			    					@endforeach
			  					</select>
				        		<select name="year_filter" class="select2_single form-control" tabindex="-1" id="howeOwnersList">
			    					<option value="2011">2011</option>
			    					<option value="2012">2012</option>
			    					<option value="2013">2013</option>
			    					<option value="2014">2014</option>
			    					<option value="2015">2015</option>
			    					<option value="2016">2016</option>
			    					<option value="2017">2017</option>
			    					<option value="2018">2018</option>
			    					<option value="2019">2019</option>
			  					</select>
			  					<input type="hidden" name="type" value="{{$type}}" />
			  					<input style="margin: 0; padding: 8px 15px;" type="submit" class="btn btn-success btn-md submit" value="Submit">
		    				{!! Form::close() !!}
			        		
			        	</div>
		    		</div>
		    	</div>
		    	<br>
	        	<div class="row">
	        		<div class="col-md-12">
	        			<table class="table table-striped table-bordered">
	        			@if($type=='homeowner')
	        				<thead>
				                <tr>
				                  	<th>Receipt#</th>
				                  	<th>Payee</th>
				                  	<th>Amount</th>
				                  	<th>Covering Month/s</th>
				                  	<th>Payment Type</th>
				                </tr>
			              	</thead>
			              	<tbody>
			              		@if(empty($listOfItem))
			        				<tr><td colspan="5" align="center"><em><strong> No Records Found </strong></em></td></tr>
			        			@else
			        				@foreach($listOfItem as $key => $value)
			              				@foreach($value as $val)
			              				<tr>
			              					<td><a href="{{route('receipt.show',$val->invoice->receipt->id)}}"><em><strong>{{sprintf("%'.07d\n", $val->invoice->receipt->receipt_no)}}</strong></em></a></td>
			              					<td>{{$key}}</td>
				              				<td>PHP {{number_format($val->amount,2)}}</td>
				              				<td>{{$val->remarks}}</td>	
				              				<td>{{$val->item->item_name}}</td>	
				              			</tr>
				              			@endforeach
			              			@endforeach
			        			@endif
			              	</tbody>
	        			@elseif($type=='vendor')
	        				<thead>
				                <tr>
				                  	<th>Cash Voucher #</th>
				                  	<th>Paid To</th>
				                  	<th>Amount</th>
				                  	<th>Description</th>
				                  	<th>Payment Type</th>
				                </tr>
			              	</thead>
			              	<tbody>
			              		@if(empty($listOfItem))
			        				<tr><td colspan="5" align="center"><em><strong> No Records Found </strong></em></td></tr>
			        			@else
			        				@foreach($listOfItem as $key => $value)
			              				@foreach($value as $val)
			              				<tr>
			              					<td><a href="{{route('expense.show',$val->expense->id)}}"><em><strong>{{sprintf("%'.07d\n", $val->expense->id)}}</strong></em></a></td>
			              					<td>{{$key}}</td>
				              				<td>PHP {{number_format($val->amount,2)}}</td>
				              				<td>{{$val->remarks}}</td>	
				              				<td>{{$val->item->item_name}}</td>	
				              			</tr>
				              			@endforeach
			              			@endforeach
			        			@endif
			              	</tbody>
	        			@endif
	        			</table>
			              	
			            
	        		</div>
	        	</div>
        		<div class="pull-right">
        			
        		</div>
        		<div style="margin-top:50px">
        			{!! Form::open(['url'=>'pdf','method'=>'POST','target'=>'_blank']) !!}
	                    @include('pdf.pdf_form',['category'=>'subsidiary_ledger_report',
	                    							'recordId'=>null,
	                    							'month_filter'=>$monthFilter,
	                    							'year_filter'=>$yearFilter,
	                    							'type'=>$type])
	                {!! Form::close() !!}
        		</div>
          	</div>
	    </div>
	</div>
@endsection