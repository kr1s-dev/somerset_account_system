@extends('master_layout.master_guest_page_layout')
@section('content')
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><i class="fa fa-clock-o"></i> Transaction History</h3>
      </div>
    </div>

    <div class="clearfix"></div>
    
    <div class="row tile_count">
      <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count tile_green">
        <span class="count_top"><i class="fa fa-money"></i> Outstanding Balance (PHP)</span>
        <div class="count">{{number_format($outstandingBalance,2)}}</div>
        <span class="count_bottom">For the month of {{date('F')}}</span>
      </div>
      <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count tile_blue">
        <span class="count_top"><i class="fa fa-user"></i> Last Transaction (PHP)</span>
        @if($transactionHistory!=NULL)
          <div class="count">{{number_format($transactionHistory->total_amount,2)}}</div>
          <span class="count_bottom">Tendered last {{date('m/d/y',strtotime($transactionHistory->updated_at))}}</span>
        @else
          <div class="count">{{number_format(0,2)}}</div>
          <span class="count_bottom">&nbsp;</span>
        @endif
      </div>
      <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count tile_red">
        <span class="count_top"><i class="fa fa-clock-o"></i> YTD Dues Paid (PHP)</span>
        <div class="count">{{number_format($totalDuesPaid,2)}}</div>
        <span class="count_bottom">&nbsp;</span>
      </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>List of all transactions</h2>
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
                  <th>Reference Number</th>
                  <th>Amount</th>
                  <th>Due Date</th>
                  <th>Date Paid</th>
                  <th>Date Created</th>
                </tr>
              </thead>
              <tbody>
                @foreach($transactionHistoryList as $transactionHistory)
                  <tr>
                    <td><a href="{{route('guestinvoice',$transactionHistory->id)}}"> <strong> {{sprintf("%'.07d\n", $transactionHistory->id)}} </strong></a></td>
                    <td>{{$transactionHistory->total_amount}}</td>
                    <td>{{date('m/d/y',strtotime($transactionHistory->payment_due_date))}}</td>
                    <td>{{date('m/d/Y',strtotime($transactionHistory->updated_at))}}</td>
                    <td>{{date('m/d/Y',strtotime($transactionHistory->created_at))}}</td>
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