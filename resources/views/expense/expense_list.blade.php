@extends('master_layout.master_page_layout')
@section('content')
 	<div class="">
    	<div class="page-title">
       	<div class="title_left">
          	<h3><i class="fa fa-credit-card"></i> Expenses</h3>
       	</div>
    	</div>
    	<div class="clearfix"></div>
    	<div class="col-md-12 col-sm-12 col-xs-12">
       	<div class="x_panel">
          	<div class="x_title">
             		<h2>View All Cash Vouchers</h2>
             		<ul class="nav navbar-right panel_toolbox">
                		<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                		</li>
             		</ul>
             		<div class="clearfix"></div>
          	</div>
          	<div class="x_content">
            		<table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              		<thead>
                			<tr>
                  			<th>Voucher #</th>
		                    <th>Account</th>
		                    <th>Paid To</th>
		                    <th>Date Created</th>
		                    <th>Amount Due</th>
		                    <th>Actions</th>
                			</tr>
              		</thead>
              		<tbody>
              			@foreach($eExpenseList as $eExpense)
              				<tr>
              					<td><a href="{{ route('expense.show',$eExpense->id) }}"><strong>#{{sprintf("%'.07d\n",$eExpense->id)}}</strong></a></td>
                				<td>2016 Somerset</td>
                				<td>{{$eExpense->paid_to}}</td>
                				<td>{{date_format($eExpense->created_at,'F d, Y')}}</td>
                				<td>{{$eExpense->total_amount}}</td>
                				<td align="center">
			                      	<a href="{{ route('expense.edit',$eExpense->id) }}" role="button" class="btn btn-default">
			                      		<i class="fa fa-pencil"></i> 
			                      	</a>
                              {!! Form::model($eExpense, ['method'=>'POST','action' => ['expense\ExpenseController@destroy',$eExpense->id] , 'class' => 'form-horizontal form-label-left']) !!}
                                <button data-toggle="modal" data-target="#confirm" class="btn btn-default"><i class="fa fa-trash"></i> </button>
                                <!-- Modal content-->
                                <div id="confirm" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <div class="modal-content pull-right col-md-12">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Confirmation</h4>
                                      </div>
                                      <div class="modal-body">
                                        <form id="nPaymentTrans">
                                          <div class="form-group">
                                          </br>
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password<span class="required">*</span>
                                            </label>
                                            <div class="col-md-9 col-sm-6 col-xs-12">
                                              <input value="" type="password" name="adminPassword" class="form-control col-md-7 col-xs-12" style="margin-bottom:2% !important" required="required">
                                            </div>
                                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            <!-- End of Modal content-->
                              {!! Form::close() !!}
			                    </td>
              				</tr>
              			@endforeach
              		</tbody>
            		</table>
          	</div>
       	</div>
    	</div>
 	</div>
@endsection