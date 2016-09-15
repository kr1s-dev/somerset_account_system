@extends('master_layout.master_page_layout')
@section('content')
  <div class="">
    <div class="page-title">
      	<div class="title_left">
        	<h3><i class="fa fa-files-o"></i> Invoices</h3>
      	</div>
    </div>
    <div class="clearfix"></div>
	  <div class="col-md-12 col-sm-12 col-xs-12">
    	<div class="x_panel">
    		<div class="x_title">
      		<h2>List of All Invoices</h2>
        		<ul class="nav navbar-right panel_toolbox">
        			<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        			</li>
        		</ul>
      		<div class="clearfix"></div>
    		</div>
    		<div class="x_content">
    		  <table id="datatable" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
       			<thead>
        			<tr>
        				<th>Invoice #</th>
        				<th>To</th>
        				<th>Payment Due</th>
        				<th>Amount Due</th>
                <th>Status</th>
        				<th>Actions</th>
      			  </tr>
      			</thead>
      			<tbody>
              @foreach($eInvoiceModelList as $eInvoice)
                <tr>
                  <td><a href="{{ route('invoice.show',$eInvoice->id) }}"><strong>#{{sprintf("%'.07d\n",$eInvoice->id)}}</strong></a></td>
                  <td>{{ $eInvoice->homeOwner->first_name}} {{ $eInvoice->homeOwner->middle_name}} {{$eInvoice->homeOwner->last_name}}</td>
                  <td>{{ date('M-d-Y ', strtotime($eInvoice->payment_due_date))}}</td>
                  <td>₱{{ $eInvoice->total_amount }}</td>
                  
                    @if($eInvoice->is_paid)
                    <td>Paid</td>
                    <td align="center">
                      <a href="#" role="button" class="btn btn-default" disabled>
                        <i class="fa fa-money"></i> 
                      </a>
                      <a href="#" role="button" class="btn btn-default" disabled>
                        <i class="fa fa-pencil"></i> 
                      </a>
                      <a href="#" role="button" class="btn btn-default" disabled>
                        <i class="fa fa-trash"></i> 
                      </a>
                    </td>
                    @else
                    <td>Pending</td>
                    <td>
                      <a href="/receipt/create/{{$eInvoice->id}}" role="button" class="btn btn-default">
                        <i class="fa fa-money"></i> 
                      </a>
                      <a href="{{ route('invoice.edit',$eInvoice->id) }}" role="button" class="btn btn-default">
                        <i class="fa fa-pencil"></i> 
                      </a>
                      {!! Form::model($eInvoice, ['method'=>'DELETE','action' => ['invoice\InvoiceController@destroy',$eInvoice->id] , 'class' => 'form-horizontal form-label-left form-wrapper']) !!}
                        <button type="submit" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </button>
                      </td>
                      {!! Form::close() !!}
                    @endif
                </tr>
              @endforeach
      			</tbody>
          </table>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
@endsection