@extends('master_layout.master_page_layout')
@section('content')
<div class="col-md-12">
  <div class="x_panel">
      <div class="x_title">
        <h2>Income and Revenue Summary</h2>
      <div class="filter">
      </div>
      <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="demo-container" style="height:280px">
              <div id="placeholder33x" class="demo-placeholder"></div>
            </div>
            <div class="tiles">
              <div class="col-md-4 tile">
                  <span>Total Revenue</span>
                <h2>PHP {{number_format($incTotalSum,2)}}</h2>
                <span class="sparkline22 graph" style="height: 160px;">
                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                    </span>
              </div>
              <div class="col-md-4 tile">
                <span>Total Expenses</span>
                <h2>PHP {{number_format($expTotalSum,2)}}</h2>
              <span class="sparkline22 graph" style="height: 160px;">
                      <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                     </span>
              </div>
            </div>
        </div>
      </div>
  </div>
  <div class="x_panel">
      <div class="x_title">
        <h2>AR (Per Week)</h2>
      <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="demo-container" style="height:280px">
              <div id="placeholder34x" class="demo-placeholder"></div>
            </div>
            <div class="tiles">
              <div class="col-md-4 tile">
                <span>Total AR (Per Week)</span>
                <h2>PHP {{number_format($totalHomeOwnerAmountPerWeek,2)}}</h2>
              <span class="sparkline22 graph" style="height: 160px;">
                      <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                     </span>
              </div>
            </div>
        </div>
      </div>
  </div>
  <div class="x_panel">
      <div class="x_title">
        <h2>AP Summary (Per Week)</h2>
      <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="demo-container" style="height:280px">
              <div id="placeholder35x" class="demo-placeholder"></div>
            </div>
            <div class="tiles">
              <div class="col-md-4 tile">
                <span>Total AP (Per Week)</span>
                <h2>PHP {{number_format($totalVendorAmountPerWeek,2)}}</h2>
              <span class="sparkline22 graph" style="height: 160px;">
                      <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                     </span>
              </div>
            </div>
        </div>
      </div>
  </div>
  <div class="x_panel">
    <div class="x_title">
      <h2><i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:red;"></i> Invoices that Exceeded Due Date</h2>
    <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <table id="datatable" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Tendered At</th>
              <th>Invoice Id</th>
              <th>Home Owner Name</th>
              <th>Payment Due Date</th>
              <th>Has Penalty</th>
              <th>Total Amount</th>
              <th>Created By</th>  
            </tr>
          </thead>
          <tbody>
            @if(count($invoiceList)>0)
              @foreach($invoiceList as $invoice)
                <tr>
                  <td>{{date('F d, Y',strtotime($invoice->created_at))}}</td>
                  <td><a href="{{route('invoice.show',$invoice->id)}}">{{sprintf("%'.07d\n",$invoice->id)}}</a></td>
                  <td><a href="{{route('homeowners.show',$invoice->home_owner_id)}}">{{$invoice->homeOwner->first_name}}&nbsp;{{$invoice->homeOwner->last_name}}</td>
                  <td>{{date('F d, Y',strtotime($invoice->payment_due_date))}}</td>
                  <td>
                    @if($invoice->penaltyInfo == NULL)
                      No
                    @else
                      <a href="{{route('invoice.show',$invoice->penaltyInfo->id)}}">Yes</a>
                    @endif
                  </td>
                  <td>PHP {{number_format($invoice->total_amount,2)}}</td>
                  <td>{{$invoice->user->first_name}}&nbsp;{{$invoice->user->last_name}}</td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection