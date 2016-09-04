@extends('master_layout.master_page_layout')
@section('content')
<!-- page content -->
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
            		<h2>Cash Voucher Details</h2>
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
                     		<h4>Cash Voucher: #{{ sprintf("%'.07d\n",$eExpenseId) }} <span class="pull-right">Date: {{date_format($eExpense->created_at,'m/d/y')}}</span></h4>
                  		</div>
                  		<!-- /.col -->
               		</div>
               		<!-- info row -->
               		<div class="row invoice-info">
                  		<div class="col-sm-4 invoice-col">
                     		<div class="form-group">
                        		<label for="" class="control-label">Created By:</label>
                       			<p>
                              @if($eExpense->user->home_owner_id != NULL)
                                 {{$eExpense->user->homeOwner->first_name}} {{$eExpense->user->homeOwner->middle_name}} {{$eExpense->user->homeOwner->last_name}}
                              @else
                                 {{$eExpense->user->first_name}} {{$eExpense->user->middle_name}} {{$eExpense->user->last_name}} 
                              @endif
                            </p>
                     		</div>
                  		</div>
                  		<div class="col-sm-4 invoice-col">
                     		<div class="form-group">
                          <label class="control-label" for="homeowner">Paid To</label>
                          @if($eExpense->paid_to != NULL)
                            <p>{{$eExpense->paid_to}}</p>
                          @else
                            <p>{{$eExpense->vendor->vendor_name}}</p>
                          @endif
                        			
                     		</div>
                  		</div>
                  		<!-- /.col -->
               		</div>
               		<!-- /.row -->
               		<!-- Table row -->
               		<div class="row">
                  	<div class="col-md-6">
                     	<table id="editable" class="table table-striped">
                        		<thead>
                           		<tr>
                              		<th style="width: 30%">Item</th>
		                            <th style="width: 60%">Description</th>
		                            <th style="width: 10%">Amount (PHP)</th>
                           		</tr>
                        		</thead>
                        		<tbody class="items-wrapper">
                                 @foreach($eExpense->expenseItems as $eExpenseItem)
                                    <tr>
                                       <td>{{$eExpenseItem->item->item_name}}</td>
                                       <td>{{$eExpenseItem->remarks}}</td>
                                       <td>{{$eExpenseItem->amount}}</td>
                                    </tr>
                                 @endforeach
                        		</tbody>
                     	</table>
                  	</div>
                  	<!-- /.col -->

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
             
                  	<!-- this row will not appear when printing -->
                  	<div class="row no-print">
                     	<div class="col-xs-12">
                        	{!! Form::open(['url'=>'pdf','method'=>'POST','target'=>'_blank']) !!}
                              @include('pdf.pdf_form',['category'=>'expense','recordId'=>$eExpense->id])
                           {!! Form::close() !!}
                     	</div>
                  	</div>
            		</section>
         	</div>
      	</div>
   	</div>
	</div>
<!-- /page content -->
@endsection