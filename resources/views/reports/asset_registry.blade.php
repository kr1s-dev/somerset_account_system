@extends('master_layout.master_page_layout')
@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="">
    	
    	<div class="row">
    		<div class="col-md-12">
				<div class="page-title">
		            <h3><i class="fa fa-file-text"></i> Asset Registry as of
		            		{{date('F')}}, {{date('Y')}}</h3>
		        </div>
			</div>
    	</div>
        <div class="clearfix"></div>

        <div class="col-md-12 col-sm-12 col-xs-12">
	        <div class="x_panel">
			    <div class="row">
		    	</div>
		    	<br>
	        	<div class="row">
	        		<div class="col-md-12">
	        			<table class="table table-striped table-bordered">
	        				<thead>
				                <tr>
				                  	<th>Asset No#</th>
				                  	<th>Item Name</th>
				                  	<th>Quantity</th>
				                  	<th>Monthly Depreciation</th>
				                  	<th>Accumulated Depreciation</th>
				                  	<th>Remaining Months</th>
				                  	<th>Net Amount</th>
				                </tr>
			              	</thead>
			              	<tbody>
			              		@if(count($assetItemList)<=0)
			        				<tr><td colspan="7" align="center"><em><strong> No Records Found </strong></em></td></tr>
			        			@else
			        				@foreach($assetItemList as $assetItem)
			              				<tr>
			              					<td><a href="{{route('assets.show',$assetItem->id)}}"><em><strong>{{sprintf("%'.07d\n", $assetItem->id)}}</strong></em></a></td>
			              					<td>{{$assetItem->item_name}}</td>
			              					<td>{{number_format($assetItem->quantity,2)}}</td>
				              				<td>PHP {{number_format($assetItem->monthly_depreciation,2)}}</td>
				              				<td>PHP {{number_format($assetItem->accumulated_depreciation,2)}}</td>	
				              				<td>{{$assetItem->useful_life}}</td>
				              				<td>{{$assetItem->net_value}}</td>	
				              			</tr>
			              			@endforeach
			        			@endif
			              	</tbody>
	        			</table>
	        		</div>
	        	</div>
        		<div class="pull-right">
        			
        		</div>
        		<div style="margin-top:50px">
        			{!! Form::open(['url'=>'pdf','method'=>'POST','target'=>'_blank']) !!}
	                    @include('pdf.pdf_form',['category'=>'asset_registry_report',
	                    							'recordId'=>null,
	                    							'month_filter'=>null,
	                    							'year_filter'=>null,
	                    							'type'=>null])
	                {!! Form::close() !!}
        		</div>
          	</div>
	    </div>
	</div>
@endsection