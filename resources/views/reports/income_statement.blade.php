@extends('master_layout.master_page_layout')
@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="">
    	
    	<div class="row">
    		<div class="col-md-12">
				<div class="page-title">
		            <h3><i class="fa fa-file-text"></i> Income Statement for
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
		    				
		    				{!! Form::open(['url'=>'reports/incomestatement','method'=>'POST']) !!}
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
			  					<input style="margin: 0; padding: 8px 15px;" type="submit" class="btn btn-success btn-md submit" value="Submit">
		    				{!! Form::close() !!}
			        		
			        	</div>
		    		</div>
		    	</div>
		    	<br>
	        	<div class="row">
	        		<div class="col-md-6">
	        			<table class="table table-striped table-bordered">
			              	<thead>
				                <tr>
				                  	<th colspan="2"><h3>Income</h3></th>
				                </tr>
			              	</thead>
			              	<tbody>
			              		@foreach($incomeItemsList as $key => $value)
			              			<tr>
			              				<td>
			              					{{$key}}
			              				</td>
			              				<td align="right">
			              					PHP {{number_format($value,2)}}
			              				</td>
			              			</tr>
			              		@endforeach
			              		<tr>
			              			<td colspan="2" align="right">
			              				<strong> Total Amount: PHP {{number_format($incTotalSum,2)}} </strong>
			              			</td>
			              		</tr>

			              	</tbody>

			            </table>
	        		</div>
	        		<div class="col-md-6">
	        			<table class="table table-striped table-bordered">
			              	<thead>
				                <tr>
				                  	<th colspan="2"><h3>Expense</h3></th>
				                </tr>
			              	</thead>
			              	<tbody>
				                @foreach($expenseItemsList as $key => $value)
			              			<tr>
			              				<td>
			              					{{$key}}
			              				</td>
			              				<td align="right">
			              					PHP {{number_format($value)}}
			              				</td>
			              			</tr>
			              		@endforeach
			              		<tr>
			              			<td colspan="2" align="right">
			              				<strong> Total Amount: PHP {{number_format($expTotalSum,2)}} </strong>
			              			</td>
			              		</tr>
			              	</tbody>
			            </table>
	        		</div>
	        	</div>
        		<div class="pull-right">
        			<strong>NET INCOME: PHP {{ number_format($incTotalSum - $expTotalSum,2) }} </strong>
        		</div>
        		<div style="margin-top:50px">
        			{!! Form::open(['url'=>'pdf','method'=>'POST','target'=>'_blank']) !!}
	                    @include('pdf.pdf_form',['category'=>'income_statement_report',
	                    							'recordId'=>null,
	                    							'month_filter'=>$monthFilter,
	                    							'year_filter'=>$yearFilter])
	                {!! Form::close() !!}
        		</div>
          	</div>
	    </div>
	</div>
@endsection