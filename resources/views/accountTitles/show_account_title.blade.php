@extends('master_layout.master_page_layout')
@section('content')
	<div class="">
		<div class="page-title">
 		  <div class="title_left">
    		<h3><i class="fa fa-table"></i> Account Title </h3>
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
                          @if($accountTitle->group->account_group_name == 'Revenues' || strpos($accountTitle->group->account_group_name,'Revenues') ||
                          $accountTitle->group->account_group_name == 'Expenses' || strpos($accountTitle->group->account_group_name,'Expenses'))
                            <a href="../accounttitle/item/create/{{$accountTitle->id}}" class="btn btn-primary pull-right">
                              <i class="fa fa-table"></i> Create Item
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
                                <td>{{$accountTitle->default_value}}</td>
                              </tr>
                            @endif
                            @if($accountTitle->group->account_group_name == 'Revenues' || $accountTitle->group->account_group_name == 'Expenses' || $accountTitle->account_title_id != NULL)
                            @else
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
              @if($accountTitle->group->account_group_name == 'Revenues' || strpos($accountTitle->group->account_group_name,'Revenues') ||
            $accountTitle->group->account_group_name == 'Expenses' || strpos($accountTitle->group->account_group_name,'Expenses'))
              <div class="panel">
                <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  <h4 class="panel-title">Account Titles Items</h4>
                </a>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                      <div class="actions">
                        @if(Auth::user()->userType->type=='Administrator')
                          <a href="../accounttitle/item/create/{{$accountTitle->id}}" class="btn btn-primary pull-right">
                            <i class="fa fa-user"></i> Add Item
                          </a>
                        @endif
                          
                      </div>
                    <table class="table table-bordered">
                      <thead>
                        <th>Item Name</th>
                        <th>Default Value</th>
                        <th>Subject to VAT</th>
                      </thead>
                      <tbody>
                        @if(empty($accountTitle->items))
                          <tr>
                            <td colspan="3" align="center"><strong><i>No Records Found</i></strong></td>
                          </tr>
                        @else
                          @foreach($accountTitle->items as $item)
                          <tr>
                            <td><a href="{{route('item.show',$item->id)}}"> {{$item->item_name}}</a></td>
                            <td>{{$item->default_value}}</td>
                            @if($item->subject_to_vat)
                              <td>Yes</td>
                            @else
                              <td>No</td>
                            @endif
                          @endforeach
                        @endif
                      </tbody>
                    </table>
                  </div>
              </div>
            @endif
          </div>
        </div>
      <!-- end of accordion -->
    </div>
	</div>
@endsection