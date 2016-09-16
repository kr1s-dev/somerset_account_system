@extends('master_layout.master_page_layout')
@section('content')
   	<div class="">
    	<div class="page-title">
       	<div class="title_left">
          	<h3><i class="fa fa-money"></i> Receipt</h3>
       	</div>
    	</div>
    	<div class="clearfix"></div>
    	<div class="col-md-12 col-sm-12 col-xs-12">
       	<div class="x_panel">
          	<div class="x_title">
             		<h2>Receipt Details</h2>
             		<ul class="nav navbar-right panel_toolbox">
                		<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                		</li>
             		</ul>
             		<div class="clearfix"></div>
          	</div>
          	<div class="x_content">
             		<section class="content receipt">
                		<!-- title row -->
                		<div class="row">
                   		<div class="col-xs-12 invoice-header">
                      		<div class="col-md-4">
                         			<h4>Receipt #: {{sprintf("%'.07d\n",$receipt->receipt_no)}}</h4>
                      		</div>
                      		<div class="col-md-4">
                         			<h4>Invoice #: {{sprintf("%'.07d\n",$invoiceNumber)}} </h4>
                      		</div>
                   		</div>
                   		<!-- /.col -->
                		</div>
                		<div class="ln_solid"></div>
                		<!-- info row -->
                		<div class="row invoice-info">
                   		<div class="col-sm-4 invoice-col">
                      		<div class="form-group">
                         			<label for="" class="control-label">Cashier</label>
                         			<h5>
                                @if($receipt->cashier->home_owner_id != NULL)
                                  {{$receipt->cashier->homeOwner->first_name}} {{$receipt->cashier->homeOwner->middle_name}} {{$receipt->cashier->homeOwner->last_name}}
                                @else
                                  {{$receipt->cashier->first_name}} {{$receipt->cashier->middle_name}} {{$receipt->cashier->last_name}}
                                @endif
                              </h5>
                      		</div>
                   		</div>
                   		<div class="col-sm-4 invoice-col">
                      		<div class="form-group">
                         			<label class="control-label" for="homeowner">To</label>
                         			<h5>{{$receipt->invoice->homeOwner->first_name}} {{$receipt->invoice->homeOwner->middle_name}} {{$receipt->invoice->homeOwner->last_name}}</h5>
                      		</div>
                   		</div>
                   		<!-- /.col -->
                   		<div class="col-sm-4 invoice-col">
                       		<label class="control-label" for="homeowner">Payment Due:</label>
                      		<div class="form-group">
                         			<h5>{{date('Y-m-d',strtotime($receipt->invoice->payment_due_date))}}</h5>
                      		</div>
                   		</div>
                   		<!-- /.col -->
                		</div>
                		<!-- /.row -->
                		<!-- Table row -->
                		<div class="row">
                   		<div class="col-md-6">
                      		<table class="table table-striped">
                         			<thead>
                              <tr>
                                <th style="width: 5%">Quantity</th>
                                <th style="width: 30%">Payment Type</th>
                                <th style="width: 54%">Covering Month/s</th>
                                <th>Amount (PHP)</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($receipt->invoice->invoiceItems as $pendingPayment)
                                <tr>
                                  <td>{{$pendingPayment->quantity}}</td>
                                  <td>{{$pendingPayment->item->item_name}}</td>
                                  <td>{{$pendingPayment->remarks}}</td>
                                  <td>{{$pendingPayment->amount}}</td>
                                </tr>
                              @endforeach
                            </tbody>
                     	 		</table>
                   		</div>
                   		<!-- /.col -->

                   		<div class="col-xs-6 pull-right">
                    			<p class="lead">Amount Due</p>
                     			<div class="table-responsive">
                       			<table class="table">
                       				<tbody>
                                <tr>
                                  <th style="width:50%">Total:</th>
                                  <td>PHP {{$receipt->invoice->total_amount}}</td>
                                </tr>
                              </tbody>
                       			</table>
                     			</div>
                   		</div>
                   		<!-- /.col -->
                   		<div class="col-xs-6 pull-right">
                     			<p class="lead">Payment Details</p>
                     			<div class="table-responsive">
                       			<table class="table">
                         				<tbody>
                           				<tr>
                           					<th style="width:50%">Date of Payment:</th>
                           					<td>{{date_format($receipt->created_at,'F d, Y')}}</td>
                           				</tr>
                                  <tr>
                                    <th style="width:50%">Amount Paid:</th>
                                    <td>PHP {{$receipt->amount_paid}}</td>
                                  </tr>
                                  <tr>
                                    <th style="width:50%">Change:</th>
                                    <td>PHP {{number_format($receipt->amount_paid - $receipt->invoice->total_amount,2)}}</td>
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
                          {!! Form::open(['url'=>'pdf','method'=>'POST','target'=>'_blank']) !!}
                            @include('pdf.pdf_form',['category'=>'receipt','recordId'=>$receipt->id])
                          {!! Form::close() !!}
                      		
                   		</div>
                		</div>
             		</section>
          	</div>
       	</div>
    	</div>
 	</div>
@endsection