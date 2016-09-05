@extends('master_layout.master_page_layout')
@section('content')
<div class="">
  	<div class="page-title">
     	<div class="title_left">
        	<h3><i class="fa fa-map-marker"></i> Map</h3>
     	</div>
  	</div>
  	<div class="clearfix"></div>
  	<div class="col-md-12 col-sm-12 col-xs-12">
     	<div class="x_panel">
        	<div class="x_title">
           		<h2>Somerset </h2>
       			<ul class="nav navbar-right panel_toolbox">
          			<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          			</li>
       			</ul>
       			<div class="clearfix"></div>
        	</div>
        	<div class="x_content map-container">
           		<img src="{{ URL::asset('images/somerset-map.png')}}" alt="" usemap="#Map" id="somerset"/>
            	<map name="Map" id="Map">
            		@foreach($blockLotList as $blockLot)
            			<area alt="" 
		                    data-block="{{explode('-',$blockLot->block_lot)[0]}}"
		                    data-lot="{{explode('-',$blockLot->block_lot)[1]}}"
		                    data-status="{{$blockLot->homeowner==NULL?'Not Occupied':'Occupied'}}"
		                    title="{{$blockLot->block_lot}} - {{$blockLot->homeowner==NULL?'Not Occupied':'Occupied'}}" 
		                    href="#" 
		                    shape="poly" 
		                    coords="{{$blockLot->coordinates}}" 
		                />
            		@endforeach
            	</map>
            	<div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      	<div class="modal-content pull-right col-md-12">
                        	<div class="modal-header">
                          		<button type="button" class="close" data-dismiss="modal">&times;</button>
                          		<h4 class="modal-title">HomeOwner Information</h4>
                        	</div>
	                        <div class="modal-body">
	                         	
	                        </div>
                      	</div>
                    </div>
                </div>
        	</div>
        	<br>
     	</div>
  	</div>
</div>
@endsection