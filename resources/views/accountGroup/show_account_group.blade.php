@extends('master_layout.master_page_layout')
@section('content')
	<div class="">
		<div class="page-title">
 		  <div class="title_left">
    		<h3><i class="fa fa-home"></i> Account Group </h3>
 		  </div>
		</div>
		<div class="clearfix"></div>

		<div class="col-md-12 col-sm-12 col-xs-12">
 		<div class="x_panel">
    		<div class="x_title">
           		<h2>{{$accountGroup->account_group_name}} </h2>
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
            			<h4 class="panel-title">Account Group Information</h4>
          			</a>
          			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            			<div class="panel-body">
                			<div class="actions">
                   				<a href="{{ route('accountgroup.edit',$accountGroup->id) }}" class="btn btn-primary pull-right">
                      				<i class="fa fa-pencil"></i> Edit
                   				</a>
                			</div>
              				<table class="table table-bordered">
                				<tbody>
                   					<tr>
                     		 			<td class="data-title"><strong>Account Group Name</strong></td>
                      					<td>{{$accountGroup->account_group_name}}</td>
                   					</tr>
                   					<tr>
                      					<td class="data-title"><strong>Description</strong></td>
                      					<td>{{$accountGroup->description}}</td>
                   					</tr>
                				</tbody>
              				</table>
            			</div>
          			</div>
        		</div>
        	<div class="panel">
          		<a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            		<h4 class="panel-title">Account Titles</h4>
          		</a>
          		<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            		<div class="panel-body">
                		<div class="actions">
                   			<a href="" class="btn btn-primary pull-right">
                      			<i class="fa fa-user"></i> Add Account Title
                   			</a>
                		</div>
              		<table class="table table-bordered">
                		<thead>
                     	<th>Title Name</th>
                     	<th>Description</th>
                     	<th>Date Created</th>
                		</thead>
                		<tbody>
                      <!--
                      @if(empty($homeOwnerMembersList))
                        <tr>
                          <td colspan="8" align="center"><strong><i>No House Members Found</i></strong></td>
                        </tr>
                      @else
                        @foreach($homeOwnerMembersList as $homeOwnerMember)
                        <tr>
                          <td>{{$homeOwnerMember->last_name}}</td>
                          <td>{{$homeOwnerMember->first_name}}</td>
                          <td>{{$homeOwnerMember->middle_name}}</td>
                          <td><i class="fa fa-venus"></i> {{$homeOwnerMember->companion_gender}}</td>
                          <td>-</td>
                          <td>-</td>
                          <td>{{$homeOwnerMember->relationship}}</td>
                          <td align="center">
                            <a href="{{ route('homeownermembers.edit',$homeOwnerMember->id) }}" role="button" class="btn btn-default">
                              <i class="fa fa-pencil"></i> 
                            </a>
                            {!! Form::model($homeOwnerMember, ['method'=>'DELETE','action' => ['homeownermember\HomeOwnerMemberController@destroy',$homeOwnerMember->id] , 'class' => 'form-horizontal form-label-left']) !!}
                                <button type="submit" class="btn btn-default"><i class="fa fa-trash" onclick="return confirm('Are you sure you want to delete this item?');"></i> </button>
                            {!! Form::close() !!}
                          </td>
                        </tr>
                        @endforeach
                      @endif
                      -->
                      
                		</tbody>
              		</table>
            	</div>
          </div>
        </div>
      </div>
      <!-- end of accordion -->
    </div>
	</div>
@endsection