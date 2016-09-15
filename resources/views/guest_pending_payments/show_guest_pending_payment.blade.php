@extends('master_layout.master_guest_page_layout')
@section('content')
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><i class="fa fa-money"></i> Pending Payments</h3>
      </div>
      
    </div>

    <div class="clearfix"></div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>List of all pending payments</h2>
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
                <th>Reference</th>
                <th>Amount</th>
                <th>Due Date</th>
                <th>Date Created</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pendingPaymentsList as $pendingPayment)
                <tr>
                  <td><a href="{{ route('guestinvoice',$pendingPayment->id) }}"><strong>{{sprintf("%'.07d\n", $pendingPayment->id)}}</strong></a></td>
                  <td>{{number_format($pendingPayment->total_amount,2)}}</td>
                  <td>{{date('m/d/y',strtotime($pendingPayment->payment_due_date))}}</td>
                  <td>{{date('m/d/Y',strtotime($pendingPayment->created_at))}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
@endsection