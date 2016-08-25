@extends('master_layout.master_page_layout')
@section('content')
	<div class="">
		<div class="page-title">
 		  <div class="title_left">
    		<h3><i class="fa fa-home"></i> Accounts Item </h3>
 		  </div>
		</div>
		<div class="clearfix"></div>

		<div class="col-md-12 col-sm-12 col-xs-12">
 		  <div class="x_panel">
    		<div class="x_title">
           		<h2>{{$item->item_name}} </h2>
           		<ul class="nav navbar-right panel_toolbox">
                  	<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  	</li>
           		</ul>
           		<div class="clearfix"></div>
    		</div>
    		<div class="x_content">
       		<!-- start accordion -->
      		<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
        		<div class="panel">
          			<a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            			<h4 class="panel-title">Account Item Information</h4>
          			</a>
          			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            			<div class="panel-body">
                			<div class="actions">
                   				<a href="{{ route('item.edit',$item->id) }}" class="btn btn-primary pull-right">
                      				<i class="fa fa-pencil"></i> Edit
                   				</a>
                          
                			</div>
              				<table class="table table-bordered">
                				<tbody>
                            <tr>
                              <td class="data-title"><strong>Account Title</strong></td>
                                <td>{{$item->accountTitle->account_sub_group_name}}</td>
                            </tr>
                            <tr>
                              <td class="data-title"><strong>Item Name</strong></td>
                              <td>{{$item->item_name}}</td>
                            </tr>
                            <tr>
                              <td class="data-title"><strong>Default Value</strong></td>
                              <td>PHP {{number_format($item->default_value,2)}}</td>
                            </tr>
                            <tr>
                              <td class="data-title"><strong>Subject to Vat</strong></td>
                              @if($item->subject_to_vat)
                                <td>Yes</td>
                              @else
                                <td>No</td>
                              @endif
                            </tr>
                            @if($item->subject_to_vat)
                              <tr>
                                <td class="data-title"><strong>Vat Percent</strong></td>
                                <td>{{number_format($item->vat_percent,2)}}%</td>
                              </tr>
                            @endif
                            <tr>
                              <td class="data-title"><strong>Description</strong></td>
                              <td>{{$item->remarks}}</td>
                            </tr>
                				</tbody>
              				</table>
            			</div>
          			</div>
        		</div>
        </div>
      </div>
      <!-- end of accordion -->
    </div>
	</div>
@endsection