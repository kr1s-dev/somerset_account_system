@extends('master_layout.master_page_layout')
@section('content')  
  <div class="">
  	<div class="page-title">
  		<div class="title_left">
    		<h3><i class="fa fa-home"></i> Homeowners</h3>
  		</div>
  	</div>
  	<div class="clearfix"></div>

  	<div class="col-md-12 col-sm-12 col-xs-12">
  		<div class="x_panel">
    		<div class="x_title">
           		<h2>{{$homeOwner->first_name}} {{$homeOwner->middle_name}} {{$homeOwner->last_name}}</h2>
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
            			<h4 class="panel-title">Personal Information</h4>
          			</a>
          			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            			<div class="panel-body">
                			<div class="actions">
                        @if(Auth::user()->userType->type=='Administrator')
                          <a href="{{ route('homeowners.edit',$homeOwner->id) }}" class="btn btn-primary pull-right">
                            <i class="fa fa-pencil"></i> Edit
                          </a>
                        @endif

                        @if($homeOwner->has_penalty)
                          <a href="{{ route('create.penalty',$homeOwner->id) }}" class="btn btn-primary pull-right">
                            <i class="fa fa-money"></i> Pay Penalty
                          </a>
                        @endif
                			</div>
              				<table class="table table-bordered">
                				<tbody>
                   					<tr>
                     		 			<td class="data-title"><strong>Last Name</strong></td>
                      					<td>{{$homeOwner->last_name}}</td>
                   					</tr>
                   					<tr>
                      					<td class="data-title"><strong>First Name</strong></td>
                      					<td>{{$homeOwner->first_name}}</td>
                   					</tr>
                   					<tr>
                      					<td class="data-title"><strong>Middle Name</strong></td>
                      					<td>{{$homeOwner->middle_name}}</td>
                   					</tr>
                   					<tr>
                      					<td class="data-title"><strong>Gender</strong></td>
                      					<td><i class="fa fa-mars"></i> {{$homeOwner->member_gender}}</td>
                   					</tr>
                   					<tr>
                      					<td class="data-title"><strong>Birthday</strong></td>
                      					<td>{{$homeOwner->member_date_of_birth}}</td>
                   					</tr>
                   					<tr>
                      					<td class="data-title"><strong>Age</strong></td>
                      					<td>{{date_diff(date_create($homeOwner->member_date_of_birth),date_create('today'))->y}}</td>
                   					</tr>
                   					<tr>
                      					<td class="data-title"><strong>Address</strong></td>
                      					<td>{{$homeOwner->member_address}}</td>
                   					</tr>
                   					<tr>
                      					<td class="data-title"><strong>Phone</strong></td>
                      					<td>{{$homeOwner->residence_tel_no}}</td>
                   					</tr>
                   					<tr>
                      					<td class="data-title"><strong>Mobile</strong></td>
                      					<td>{{$homeOwner->member_mobile_no}}</td>
                   					</tr>
                   					<tr>
                      					<td class="data-title"><strong>Email</strong></td>
                      					<td>{{$homeOwner->member_email_address}}</td>
                   					</tr>
                            <tr>
                                <td class="data-title"><strong>Subdivision Address</strong></td>
                                <td>{{$homeOwner->address->block_lot}}</td>
                            </tr>
                				</tbody>
              				</table>
            			</div>
          			</div>
        		</div>
        	<div class="panel">
          		<a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            		<h4 class="panel-title">Household Members</h4>
          		</a>
          		<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            		<div class="panel-body">
                		<div class="actions">
                      @if(Auth::user()->userType->type=='Administrator')
                        <a href="/homeownermembers/create/{{$homeOwner->id}}" class="btn btn-primary pull-right">
                          <i class="fa fa-user"></i> Add HouseHold Member
                        </a>
                      @endif
                   			
                		</div>
              		<table class="table table-bordered">
                		<thead>
                     	<th>Last Name</th>
                     	<th>First Name</th>
                     	<th>Middle Name</th>
                     	<th>Gender</th>
                     	<th>Birthday</th>
                     	<th>Age</th>
                     	<th>Relationship</th>
                      <th>Actions</th>
                		</thead>
                		<tbody>
                      @if(empty($homeOwnerMembersList))
                        <tr>
                          <td colspan="8" align="center"><strong><i>No Records Found</i></strong></td>
                        </tr>
                      @else
                        @foreach($homeOwnerMembersList as $homeOwnerMember)
                        <tr>
                          <td>{{$homeOwnerMember->last_name}}</td>
                          <td>{{$homeOwnerMember->first_name}}</td>
                          <td>{{$homeOwnerMember->middle_name}}</td>
                          <td><i class="fa fa-venus"></i> {{$homeOwnerMember->companion_gender}}</td>
                          <td>{{$homeOwnerMember->companion_date_of_birth}}</td>
                          <td>{{date_diff(date_create($homeOwnerMember->companion_date_of_birth),date_create('today'))->y}}</td>
                          <td>{{$homeOwnerMember->relationship}}</td>
                          <td align="center">
                            <a href="{{ route('homeownermembers.edit',$homeOwnerMember->id) }}" role="button" class="btn btn-default">
                              <i class="fa fa-pencil"></i> 
                            </a>
                            {!! Form::model($homeOwnerMember, ['method'=>'DELETE','action' => ['homeownermember\HomeOwnerMemberController@destroy',$homeOwnerMember->id] , 'class' => 'form-horizontal form-label-left']) !!}
                                <button type="submit" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </button>
                            {!! Form::close() !!}
                          </td>
                        </tr>
                        @endforeach
                      @endif
                		</tbody>
              		</table>
            	</div>
          </div>
        </div>
        <div class="panel">
          	<a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            	<h4 class="panel-title">Pending Payments</h4>
          	</a>
          	<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            	<div class="panel-body">
                	<table id="data-table" class="table table-bordered" style="width: 100%;">
                   		<thead>
                      		<th>Invoice Number</th>
                      		<th>Amount</th>
                      		<th>Date Charged</th>
                      		<th>Due Date</th>
                   		</thead>
                   		<tbody>
                         @if(empty($ehomeOwnerInvoicesList))
                          <tr>
                            <td colspan="8" align="center"><strong><i>No Records Found</i></strong></td>
                          </tr>
                        @else
                          @foreach($ehomeOwnerInvoicesList as $ehomeOwnerInvoice)
                            <tr>
                              <td><a href="{{ route('invoice.show',$ehomeOwnerInvoice->id) }}">#{{sprintf("%'.07d\n",$ehomeOwnerInvoice->id)}}</a></td>
                              <td>{{$ehomeOwnerInvoice->total_amount}}</td>
                              <td>{{date('F d, Y',strtotime($ehomeOwnerInvoice->created_at))}}</td>
                              <td>{{date('F d, Y',strtotime($ehomeOwnerInvoice->payment_due_date))}}</td>
                            </tr>
                          @endforeach
                        @endif
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