@extends('master_layout.master_guest_page_layout')
@section('content')
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><i class="fa fa-dashboard "></i> Dashboard</h3>
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
        <div class="count">{{number_format($lastTransaction,2)}}</div>
        @if($lastTransaction!=0)
          <span class="count_bottom">Tendered last {{date('m/d/y',strtotime($transactionHistory->updated_at))}}</span>
        @else
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
          <h2>Announcements</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
          @if(count($announcementsList)==0)
            No Announcements
          @else
            @foreach($announcementsList as $announcement)
              <h3><a href="{{route('guestannouncement',$announcement->id)}}"><strong>{{$announcement->headline}}</strong><a/></h3>
              <h5>{{date('m/d/y',strtotime($announcement->created_at))}}</h5>
              <p>{{$announcement->message}}</p>
              <p>- Somerset Homeowners' Association</p>
            @endforeach
          @endif
          
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
@endsection