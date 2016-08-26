@extends('master_layout.master_page_layout')
@section('content')
<div class="col-md-12">
    <div class="x_panel">
      	<div class="x_title">
        	<h2>Income and Revenue Summary</h2>
    		<div class="filter">
      			<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
        			<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
        			<span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
      			</div>
    		</div>
    		<div class="clearfix"></div>
      	</div>
      	<div class="x_content">
        	<div class="col-md-12 col-sm-12 col-xs-12">
          		<div class="demo-container" style="height:280px">
            		<div id="placeholder33x" class="demo-placeholder"></div>
          		</div>
          		<div class="tiles">
	            	<!--div class="col-md-4 tile">
	              		<span>Total Sessions</span>
	          			<h2>231,809</h2>
	      				<span class="sparkline11 graph" style="height: 160px;">
	                      	<canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
	                  	</span>
	            	</div-->
	            	<div class="col-md-4 tile">
	              		<span>Total Revenue</span>
	          			<h2>PHP {{number_format($incTotalSum,2)}}</h2>
	          			<span class="sparkline22 graph" style="height: 160px;">
	                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
	                    </span>
	            	</div>
	            	<div class="col-md-4 tile">
	          			<span>Total Expenses</span>
	          			<h2>PHP {{number_format($expTotalSum,2)}}</h2>
	      				<span class="sparkline22 graph" style="height: 160px;">
	                    	<canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
	                     </span>
	            	</div>
          		</div>
        	</div>
      	</div>
    </div>
    <div class="x_panel">
      	<div class="x_title">
        	<h2>AR (Per Week)</h2>
    		<!--div class="filter">
      			<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
        			<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
        			<span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
      			</div>
    		</div-->
    		<div class="clearfix"></div>
      	</div>
      	<div class="x_content">
        	<div class="col-md-12 col-sm-12 col-xs-12">
          		<div class="demo-container" style="height:280px">
            		<div id="placeholder34x" class="demo-placeholder"></div>
          		</div>
          		<div class="tiles">
	            	<!--div class="col-md-4 tile">
	              		<span>Total Sessions</span>
	          			<h2>231,809</h2>
	      				<span class="sparkline11 graph" style="height: 160px;">
	                      	<canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
	                  	</span>
	            	</div-->
	            	<!--div class="col-md-4 tile">
	              		<span>Total Revenue</span>
	          			<h2>PHP {{number_format($incTotalSum,2)}}</h2>
	          			<span class="sparkline22 graph" style="height: 160px;">
	                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
	                    </span>
	            	</div-->
	            	<div class="col-md-4 tile">
	          			<span>Total AR (Per Week)</span>
	          			<h2>PHP {{number_format($totalHomeOwnerAmountPerWeek,2)}}</h2>
	      				<span class="sparkline22 graph" style="height: 160px;">
	                    	<canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
	                     </span>
	            	</div>
          		</div>
        	</div>
      	</div>
    </div>
    <div class="x_panel">
      	<div class="x_title">
        	<h2>AP Summary (Per Week)</h2>
    		<!--div class="filter">
      			<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
        			<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
        			<span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
      			</div>
    		</div-->
    		<div class="clearfix"></div>
      	</div>
      	<div class="x_content">
        	<div class="col-md-12 col-sm-12 col-xs-12">
          		<div class="demo-container" style="height:280px">
            		<div id="placeholder35x" class="demo-placeholder"></div>
          		</div>
          		<div class="tiles">
	            	<!--div class="col-md-4 tile">
	              		<span>Total Sessions</span>
	          			<h2>231,809</h2>
	      				<span class="sparkline11 graph" style="height: 160px;">
	                      	<canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
	                  	</span>
	            	</div-->
	            	<!--div class="col-md-4 tile">
	              		<span>Total Revenue</span>
	          			<h2>PHP {{number_format($incTotalSum,2)}}</h2>
	          			<span class="sparkline22 graph" style="height: 160px;">
	                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
	                    </span>
	            	</div-->
	            	<div class="col-md-4 tile">
	          			<span>Total AP (Per Week)</span>
	          			<h2>PHP {{number_format($totalVendorAmountPerWeek,2)}}</h2>
	      				<span class="sparkline22 graph" style="height: 160px;">
	                    	<canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
	                     </span>
	            	</div>
          		</div>
        	</div>
      	</div>
    </div>
</div>
@endsection