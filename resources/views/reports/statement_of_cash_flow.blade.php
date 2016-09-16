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
		              				<td>
		              					Total Profit
		              				</td>
		              				@if($totalProfit>0)
		              					<td colspan="2" align="right">PHP {{number_format($totalProfit,2,'.',',')}}</td>
		              				@else
		              					<td colspan="2" align="left">PHP {{number_format($totalProfit,2,'.',',')}}</td>
		              				@endif
		              			</tr>
		              			<tr>
		              				<td colspan="3">
		              					Adjustments for:
		              				</td>
		              			</tr>
		              			@if($depreciationValue != 0)
			              			<tr>
			              				<td>
			              					Depreciation and Amortization
			              				</td>
			              				<td colspan="2" align="right">PHP {{number_format($depreciationValue,2,'.',',')}}</td>
			              			</tr>
		              			@endif
		              			@foreach($accountTitleList as $key => $value)
		              				@if($key == 'Current Assets')
		              					@foreach($value as $val)
		              						@if(strrpos('x'. $val->account_sub_group_name, 'Cash')===false)
		              							@if($val->opening_balance < 0 )
		              								@if($key == 'Current Assets')
		              									<tr>
		              										<td>Decrease on {{$val->account_sub_group_name}}</td>
		              										<td colspan="2" align="left">PHP {{number_format($val->opening_balance,2,'.',',')}}</td>
		              									</tr>
		              								@else
		              									<tr>
		              										<td>Increase on {{$val->account_sub_group_name}}</td>
		              										<td colspan="2" align="left">PHP {{number_format($val->opening_balance,2,'.',',')}}</td>
		              									</tr>
		              								@endif
		              							@elseif($val->opening_balance > 0 )
		              								@if(strrpos($key, 'Asset'))
		              									<tr>
		              										<td>Increase on {{$val->account_sub_group_name}}</td>
		              										<td colspan="2" align="left">PHP {{number_format($val->opening_balance,2,'.',',')}}</td>
		              									</tr>
		              								@else
		              									<tr>
		              										<td>Decrease on {{$val->account_sub_group_name}}</td>
		              										<td colspan="2" align="left">PHP {{number_format($val->opening_balance,2,'.',',')}}</td>
		              									</tr>
		              								@endif
		              							@endif
		              						@endif
		              					@endforeach
		              				@endif
		              			@endforeach
			              		<tr>
			              			<td colspan="2"> <strong>Cash generated from operations</strong></td>
			              			<td><u>PHP {{(number_format($totalProfit+$totalOperationCash+$depreciationValue,2,'.',','))}}</u></td>
			              		</tr>
			              	</tbody>
			              	<thead>
				                <tr>
				                  	<th colspan="3"><h3>Cash Flow from Investing Activities</h3></th>
				                </tr>
			              	</thead>
			              	<tbody>
			              		@foreach($investmentActivities as $key => $value)
			              			<tr>
				              			<td>{{$key}}</td>
				              			<td colspan="2" align="left">PHP {{number_format($value,2,'.',',')}}</td>
			              			</tr>
			              		@endforeach
			              		<tr>
			              			<td colspan="2"> <strong>Net cash used in investing activities</strong></td>
			              			<td><u>PHP {{(number_format($totalInvestmentCash,2,'.',','))}}</u></td>
			              		</tr>
			              	</tbody>
			              	<thead>
				                <tr>
				                  	<th colspan="3"><h3>Cash Flow from Financing Activities</h3></th>
				                </tr>
			              	</thead>
			              	<tbody>
			              		@foreach($accountTitleList as $key => $value)
			              			@if(strpos('x' . $key, 'Non-Current Liabilities'))
			              				@foreach($value as $val)
			              					@if(strrpos('x'.$val->account_sub_group_name,'Loan'))
			              						@if($val->opening_balance < 0 )
				              						<tr>
				              							<td>Paid: {{$val->account_sub_group_name}}</td>
				              							<td colspan="2" align="left">PHP {{number_format($val->opening_balance,2,'.',',')}}</td>
				              						</tr>
				              					@elseif($val->opening_balance > 0 )
				              						<tr>
				              							<td>Borrowed from: {{str_replace('Loan', '', $val->account_sub_group_name)}}</td>
				              							<td colspan="2" align="left">PHP {{number_format($val->opening_balance,2,'.',',')}}</td>
				              						</tr>
				              					@endif
			              					@endif
			              					
			              				@endforeach
			              			@endif
			              		@endforeach

			              		@foreach($accountTitleList as $key => $value)
			              			@if(strpos('x' . $key, 'Equity'))
			              				@foreach($value as $val)
			              					@if($val->opening_balance < 0 )
			              						<tr>
			              							<td>Decrease: {{$val->account_sub_group_name}}</td>
			              							<td colspan="2" align="left">PHP {{number_format($val->opening_balance,2,'.',',')}}</td>
			              						</tr>
			              					@elseif($val->opening_balance > 0 )
			              						<tr>
			              							<td>Increase in: {{$val->account_sub_group_name}}</td>
			              							<td colspan="2" align="left">PHP {{number_format($val->opening_balance,2,'.',',')}}</td>
			              						</tr>
			              					@endif
			              				@endforeach
			              			@endif
			              		@endforeach
			              		<tr>
			              			<td colspan="2"> <strong>Net cash used in financing activities</strong></td>
			              			<td><u>PHP {{(number_format($totalFinancingCash,2,'.',','))}}</u></td>
			              		</tr>
			              	</tbody>
			              	<thead>
				                <tr>
				                  	<td colspan="2"><h3>Total Cash In Hand</h3></td>
				                  	<td align="right">PHP {{number_format(($totalProfit+$totalOperationCash)-$totalInvestmentCash+$totalFinancingCash+$depreciationValue,2,'.',',')}}</td>
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