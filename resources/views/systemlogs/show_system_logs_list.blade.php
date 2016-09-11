@extends('master_layout.master_page_layout')
@section('content')
	<div class="">
   	<div class="page-title">
      	<div class="title_left">
         	<h3><i class="fa fa-archive"></i> System Logs</h3>
   	   	</div>
   	</div>
   	<div class="clearfix"></div>
   	<div class="col-md-12 col-sm-12 col-xs-12">
      	<div class="x_panel">
         	<div class="x_title">
               	<h2>List of System Logs</h2>
           		<ul class="nav navbar-right panel_toolbox">
              		<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              		</li>
           		</ul>
               	<div class="clearfix"></div>
         	</div>
         	<div class="x_content">
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
            			@foreach($systemLogsList as $systemLog)
            				<tr>
            					<td>{{date('F d, Y',strtotime($systemLog->created_at))}}<strong>
                           <td>{{$systemLog->action}}</td>
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