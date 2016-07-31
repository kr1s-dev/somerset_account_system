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
	               	<h2>List of All Assets</h2>
	           		<ul class="nav navbar-right panel_toolbox">
	              		<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	              		</li>
	           		</ul>
	               	<div class="clearfix"></div>
            	</div>
            	<div class="x_content">
                	<div class="row">
                    	<div class="col-md-12">
                        	<a href="{{route('assets.create')}}" role="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Create New Asset</a>
                    	</div>
               	 	</div>
                	<br>
               		<table id="datatable" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                  		<thead>
                     		<tr>
                        		<th>Asset No.</th>
                        		<th>Item Name</th>
                        		<th style="width: 2%;">Mode of Acquisition</th>
                        		<th style="width: 2%;">Monthly Depreciation</th>
                        		<th>Net Amount (PHP)</th>
                        		<th>Actions</th>
                     		</tr>
                  		</thead>
                  		<tbody>
                  			@foreach($assetModelsList as $assetModel)
                  				<tr>
                  					<td><a href="{{route('assets.show',$assetModel->id)}}"><strong>{{sprintf("%'.07d\n", $assetModel->id)}}</strong></a></td>	
                  					<td> {{ $assetModel->item_name }}</td>		
                                 <td>
                                    @if($assetModel->mode_of_acquisition == 'Both')
                                       Cash and Accounts Payable
                                    @else
                                       {{$assetModel->mode_of_acquisition}}
                                    @endif
                                 </td>
                  					<td>PHP {{ number_format($assetModel->monthly_depreciation,2) }}</td>	
                  					<td>PHP {{ number_format($assetModel->net_value,2) }}</td>	
                  					<td align="center">
	                           			<a href="{{route('assets.edit',$assetModel->id)}}" role="button" class="btn btn-default">
	                           				<i class="fa fa-pencil"></i> 
	                           			</a>
	                           			{!! Form::model($assetModel, ['method'=>'DELETE','action' => ['assets\AssetController@destroy',$assetModel->id] , 'class' => 'form-horizontal form-label-left form-wrapper']) !!}
						                        <button type="submit" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash" ></i> </button>
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