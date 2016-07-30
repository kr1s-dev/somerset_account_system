@extends('master_layout.master_page_layout')
@section('content')
	<div class="">
		<div class="page-title">
 		  <div class="title_left">
    		<h3><i class="fa fa-home"></i> Account Title </h3>
 		  </div>
		</div>
		<div class="clearfix"></div>

		<div class="col-md-12 col-sm-12 col-xs-12">
 		  <div class="x_panel">
    		<div class="x_title">
           		<h2>{{$accountTitle->account_sub_group_name}} </h2>
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
            			<h4 class="panel-title">Account Title Information</h4>
          			</a>
          			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            			<div class="panel-body">
                			<div class="actions">
                   				<a href="{{ route('accounttitle.edit',$accountTitle->id) }}" class="btn btn-primary pull-right">
                      				<i class="fa fa-pencil"></i> Edit
                   				</a>
                          @if(is_null($accountTitle->account_title_id))
                            <a href="../accounttitle/create/{{$accountTitle->id}}" class="btn btn-primary pull-right">
                              <i class="fa fa-table"></i> Create Contra {{$accountTitle->group->account_group_name}}
                            </a>
                          @endif
                          
                			</div>
              				<table class="table table-bordered">
                				<tbody>
                            <tr>
                              <td class="data-title"><strong>Account Group</strong></td>
                                <td>{{$accountGroupList->account_group_name}}</td>
                            </tr>
                            @if(!is_null($accountTitle->account_title_id))
                              <tr>
                                <td class="data-title"><strong>Account Parent Title</strong></td>
                                  <td>{{$accountTitle->accountTitleParent->account_sub_group_name}}</td>
                              </tr>
                            @endif
                   					<tr>
                     		 			<td class="data-title"><strong>Account Title Name</strong></td>
                      					<td>{{$accountTitle->account_sub_group_name}}</td>
                   					</tr>
                            @if($accountGroupList->account_group_name == '')
                              <tr>
                                <td class="data-title"><strong>Account Title Name</strong></td>
                                  <td>{{$accountTitle->default_value  }}</td>
                              </tr>
                            @endif
                   					<tr>
                    					<td class="data-title"><strong>Opening Balance</strong></td>
                              <td>
                                @if(strpos($accountGroupList->account_group_name, 'Assets') || strpos($accountGroupList->account_group_name, 'Expenses'))
                                  Dr 
                                @else
                                  Cr
                                @endif
                                {{$accountTitle->opening_balance}}
                              </td>
                   					</tr>
                            @if($accountTitle->group->account_group_name == 'Revenues')
                            <tr>
                              <td class="data-title"><strong>Default Revenue</strong></td>
                              <td>
                                PHP {{number_format($accountTitle->default_value,2)}}
                              </td>
                            </tr>
                            @endif
                            <tr>
                                <td class="data-title"><strong>Description</strong></td>
                                <td>{{$accountTitle->description}}</td>
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