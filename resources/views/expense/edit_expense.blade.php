@extends('master_layout.master_page_layout')
@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="expense-id" content="{{ $eExpense->id }}">
  <meta name="type" content="{{ $type }}">
   	<div class="">
      	<div class="page-title">
         	<div class="title_left">
            	<h3><i class="fa fa-credit-card"></i> Cash Voucher</h3>
         	</div>
      	</div>
      	<div class="clearfix"></div>
      	<div class="col-md-12 col-sm-12 col-xs-12">
         	<div class="x_panel">
            	<div class="x_title">
               		<h2>Update Cash Voucher</h2>
               		<ul class="nav navbar-right panel_toolbox">
                  		<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  		</li>
               		</ul>
               		<div class="clearfix"></div>
            	</div>
            	<div class="x_content">
               		<section class="content invoice">
                  		<!-- title row -->
                  		<div class="row">
                     		<div class="col-xs-12 invoice-header">
                        		<h4>Cash Voucher: #{{ sprintf("%'.07d\n",$eExpenseId) }}<span class="pull-right">Date: {{date_format($eExpense->created_at,'m/d/y')}}</span></h4>
                     		</div>
                     		<!-- /.col -->
                  		</div>
                  		<!-- info row -->
                  		<div class="row invoice-info">
                     		<div class="col-sm-4 invoice-col">
                        		<div class="form-group">
                           			<label for="" class="control-label">Created By:</label>
                         				<h5>
                                  @if($eExpense->user->home_owner_id != NULL)
                                     {{$eExpense->user->homeOwner->first_name}} {{$eExpense->user->homeOwner->middle_name}} {{$eExpense->user->homeOwner->last_name}}
                                  @else
                                     {{$eExpense->user->first_name}} {{$eExpense->user->middle_name}} {{$eExpense->user->last_name}} 
                                  @endif
                         </h5>
                        		</div>
                     		</div>
                        <div class="col-sm-4 invoice-col">
                           <label class="control-label">Type</label>
                           <div class="form-group">
                                <div id="gender" class="btn-group" data-toggle="buttons">
                                  @if($eExpense->paid_to!='')
                                    <label class="btn btn-default active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="type" value="Non-Vendor" data-parsley-multiple="gender" checked> Non-Vendor
                                    </label>
                                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="type" value="Vendor" data-parsley-multiple="gender"> Vendor
                                    </label>
                                  @else
                                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="type" value="Non-Vendor" data-parsley-multiple="gender"> Non-Vendor
                                    </label>
                                    <label class="btn btn-default active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="type" value="Vendor" data-parsley-multiple="gender" checked> Vendor
                                    </label>
                                  @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 invoice-col" id="vendorList" style="display:none;">
                          <label class="control-label" for="homeowner">Vendor</label>
                          <div class="form-group">
                            <select id="vendor_id" class=" select2_single form-control">
                              @foreach($vendorList as $key => $value)
                                <option value="{{ $key }} ">{{ $value }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4 invoice-col" id="non_vendor" style="display:none;">
                            <div class="form-group">
                                <label class="control-label" for="homeowner">Paid To</label>
                                <input id="paid_to" value="{{$eExpense->paid_to}}" name="paid_to" type="text" class="form-control">
                            </div>
                        </div>
                     		<!--div class="col-sm-4 invoice-col">
                        		<div class="form-group">
                           			<label class="control-label" for="homeowner">Paid To</label>
                           			<input value="{{$eExpense->paid_to}}" id="paid_to" name="paid_to" type="text" class="form-control">
                        		</div>
                     		</div-->
                     		<!-- /.col -->
                  		</div>
                  		<!-- /.row -->
                  		<!-- Table row -->
                  		<div class="row">
                     		<div class="col-md-6">
                        		<table class="table table-striped" id="itemsTable">
                           			<thead>
                              			<tr>
                              				<th style="width: 30%">Item</th>
				                            <th style="width: 60%">Description</th>
				                            <th style="width: 10%">Amount (PHP)</th>
				                        </tr>
                           			</thead>
                           			<tbody class="items-wrapper">
                           				@foreach($eExpense->expenseItems as $eExpenseItem )
                           					<tr>
                           						<td>{{$eExpenseItem->item->item_name}}</td>
                           						<td>{{$eExpenseItem->remarks}}</td>
                           						<td>{{$eExpenseItem->amount}}</td>
                           						<td>
                           							<button class="btn btn-default edit-item" id="editTrans" data-toggle="modal" data-target="#myModalEdit">
                           								<i class="fa fa-pencil"></i>
                           							</button> 
                           							<button class="btn btn-default delete-item">
                           								<i class="fa fa-times"></i>
                           							</button>
                           						</td>
                           					</tr>
                           				@endforeach()
                           			</tbody>
                        		</table>
                        		<button class="btn btn-primary pull-right add-item" id="addItemRow" data-toggle="modal" data-target="#myModal">
			                        Add
			                    </button>
                     		</div>
                     		<!-- /.col -->

                     		<!-- Modal used for adding row in table -->
                        <!-- Modal content-->
                        <div id="myModal" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content pull-right col-md-12">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">New Item</h4>
                              </div>
                              <div class="modal-body">
                                <form id="nPaymentTrans">
                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Particulars<span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                      <select id="nPaymentItem" name="account_group_id" class="select2_single form-control" tabindex="-1" style="width:100%;">
                                        <option></option>
                                        @foreach($expenseAccountItems as $eExpenseTitle)
                                          <option value="{{$eExpenseTitle->id}}">{{$eExpenseTitle->item_name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                  </br>
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description<span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                      <input value="" type="text" id="nPaymentDesc" class="form-control col-md-7 col-xs-12" style="margin-bottom:2% !important" required="required">
                                    </div>
                                  </div>
                          
                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Amount (PHP) <span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                      <input value="" type="number" step="0.01" id="nPaymentCost" class="form-control col-md-7 col-xs-12" style="margin-bottom:2% !important" required="required">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3"> 
                                      <button type="submit" class="btn btn-success pull-right add-item" id="nPaymentBtn" data-dismiss="modal">Add Item</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End of Modal content-->

                         <!-- Modal used for editing row in table -->
                         <!-- Modal content-->
                         <div id="myModalEdit" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content pull-right col-md-12">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Update Item</h4>
                              </div>
                              <div class="modal-body">
                                <form id="nPaymentTrans">
                                  <div class="form-group">
                                  </br>
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description<span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                      <input value="" type="text" id="ePaymentDesc" class="form-control col-md-7 col-xs-12" style="margin-bottom:2% !important" required="required">
                                    </div>
                                  </div>
                          
                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Amount (PHP) <span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                      <input value="" type="number" step="0.01" id="ePaymentCost" class="form-control col-md-7 col-xs-12" style="margin-bottom:2% !important" required="required">
                                    </div>
                                  </div>  
                                  <div class="form-group">
                                    <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3"> 
                                      <button type="submit" class="btn btn-success pull-right add-item" id="ePaymentBtn" data-dismiss="modal">Update Item</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End of Modal content-->
                     		<div class="col-xs-6 pull-right">
                       			<p class="lead">Amount Due</p>
                       			<div class="table-responsive">
                         			<table class="table" id="amountCalc">
                           				<tbody>
                             				<tr>
                               					<th style="width:50%">Total:</th>
                               					<td>PHP {{$eExpense->total_amount}}</td>
                             				</tr>
                           				</tbody>
                         			</table>
                       			</div>
                     		</div>
                     		<!-- /.col -->
                  		</div>
                  		<!-- this row will not appear when printing -->
                  		<div class="row no-print">
                     		<div class="col-xs-12">
                        		<!--button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button -->
                            <a href="{{route('expense.index')}}" class="btn btn-primary">Cancel</a>
                        		<!--button class="btn btn-success pull-right" id="updateExpBtn"><i class="fa fa-credit-card"></i> Update Expense Record</button-->
                            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#confirm"><i class="fa fa-credit-card"></i> Update Expense Record</button>
                        		<!--button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button-->
                            <!-- Modal content-->
                            <div id="confirm" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                                <div class="modal-content pull-right col-md-12">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Confirmation</h4>
                                  </div>
                                  <div class="modal-body">
                                    <form id="nPaymentTrans" onsubmit="return false;">
                                      <div class="form-group">
                                      </br>
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password<span class="required">*</span>
                                        </label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                          <input value="" type="password" id="adminPassword" class="form-control col-md-7 col-xs-12" style="margin-bottom:2% !important" required="required">
                                        </div>
                                        <button type="button" class="btn btn-success pull-right" id="updateExpBtn"><i class="fa fa-credit-card"></i> Submit</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End of Modal content-->
                     		</div>
                  		</div>
               		</section>
            	</div>
         	</div>
      	</div>
   	</div>
<!-- /page content -->
@endsection