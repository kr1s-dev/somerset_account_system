@extends('master_layout.master_page_layout')
@section('content')
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><i class="fa fa-table"></i> Accounts</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Somerset Accounting</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              </ul>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                <div class="col-md-12">
                  <div class="pull-right">
                    <a href="{{route('close.accounting')}}" class="btn btn-success" onclick="return confirm('Are you sure you want to close accouting year?');"><i class="fa fa-archive" aria-hidden="true"></i> Close Current Accounting Year</a>
                  </div>
                </div>
                <div class="col-md-12 col-xs-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">Account Details</div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-2 col-xs-12">
                             <h5>Name:</h5>
                          </div>
                          <div class="col-md-4 col-xs-12">
                             <h6><strong>Somerset Accounting</strong></h6>
                          </div>
                          <div class="col-md-2 col-xs-12">
                             <h5>Calendar Year:</h5>
                          </div>
                          <div class="col-md-4 col-xs-12">
                             <h6><strong>{{date('Y')}}</strong></h6>
                          </div>
                        </div>
                        <div class="ln_solid"></div>
                      </div>
                     </div>
                  </div>
                  <!--div class="col-md-4 col-xs-12">
                    <div class="panel panel-default">
                      <div class="panel-heading">Bank and Cash Summary</div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-6 col-xs-12">
                            <h5>Account Receivables</h5>
                          </div>
                          <div class="col-md-6 col-xs-12">
                            <h6>Dr 0</h6>
                          </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="row">
                          <div class="col-md-6 col-xs-12">
                             <h5>Account Payables</h5>
                          </div>
                          <div class="col-md-6 col-xs-12">
                            <h6>Cr 0</h6>
                          </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="row">
                          <div class="col-md-6 col-xs-12">
                            <h5>Bank Deposits</h5>
                          </div>
                          <div class="col-md-6 col-xs-12">
                            
                            <h6>Dr 0</h6>
                          </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="row">
                          <div class="col-md-6 col-xs-12">
                            <h5>Supplies</h5>
                          </div>
                          <div class="col-md-6 col-xs-12">
                            <h6>Dr 0</h6>
                          </div>
                        </div>
                        <div class="ln_solid"></div>
                      </div>
                    </div>
                  </di-->
                  <div class="col-md-12 col-xs-12">
                    <div class="panel panel-default">
                      <div class="panel-heading">Account Summary</div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-2 col-xs-12">
                            <h5>Assets</h5>
                          </div>
                          <div class="col-md-4 col-xs-12">
                            <h6> 
                              @if($assetTotal<0)
                                CR {{number_format(($assetTotal*-1),2)}}
                              @else
                                DR {{number_format($assetTotal,2)}}
                              @endif
                            </h6>
                          </div>
                          <div class="col-md-2 col-xs-12">
                            <h5>Liabilities</h5>
                          </div>
                          <div class="col-md-4 col-xs-12">
                            <h6>
                              @if($liabilitiesTotal<0)
                                DR {{number_format(($liabilitiesTotal*-1),2)}}
                              @else
                                CR {{number_format($liabilitiesTotal,2)}}
                              @endif
                            </h6>
                          </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="row">
                          <div class="col-md-2 col-xs-12">
                             <h5>Income</h5>
                          </div>
                          <div class="col-md-4 col-xs-12">
                             <h6>Dr {{number_format($incomeTotal,2)}}</h6>
                          </div>
                          <div class="col-md-2 col-xs-12">
                            <h5>Expenses</h5>
                          </div>
                          <div class="col-md-4 col-xs-12">
                            <h6>Cr {{number_format($expenseTotal,2)}}</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <h3>List of Entries</h3>
                  <div class="ln_solid"></div>
                  <div>
                    <!-- Single button -->
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Create New Entry <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">  
                        <li><a href="{{route('invoice.create')}}">Invoice</a></li>
                        <!--li><a href="../receipt/create.html">Receipt</a></li>
                        <li><a href="../income/create.html">Income</a></li-->
                        <li><a href="{{route('expense.create')}}">Expense</a></li>
                        <li><a href="{{route('journal')}}">Journal Entry</a></li>
                        <li><a href="{{route('adjustment.journal')}}">Adjustment Journal Entry</a></li>
                      </ul>
                    </div>
                  </div>
                  <br>
                  <table id="datatable" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Ref Number</th>
                        <th width="30%">Description</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Debit Amount</th>
                        <th>Credit Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($journalEntryCurrentYearList as $journalEntry)
                        <tr>
                          <td>{{date('m/d/Y',strtotime($journalEntry->created_at))}}</td>
                          @if($journalEntry->invoice_id != NULL)
                            <td><a href="{{ route('invoice.show',$journalEntry->invoice_id) }}"><strong>#{{sprintf("%'.07d\n", $journalEntry->invoice_id)}}</strong></a></td>
                          @elseif($journalEntry->receipt_id != NULL)
                            <td><a href="{{ route('receipt.show',$journalEntry->receipt_id) }}"><strong>#{{sprintf("%'.07d\n", $journalEntry->receipt->receipt_no)}}</strong></a></td>
                          @elseif($journalEntry->expense_id != NULL)
                            <td><a href="{{ route('expense.show',$journalEntry->expense_id) }}"><strong>#{{sprintf("%'.07d\n", $journalEntry->expense_id)}}</strong></a></td>
                          @elseif($journalEntry->asset_id != NULL)
                            <td><a href="{{ route('assets.show',$journalEntry->asset_id) }}"><strong>#{{sprintf("%'.07d\n", $journalEntry->asset_id)}}</strong></a></td>
                          @else
                            <td></td>
                          @endif
                          <td>{{$journalEntry->description}}</td>
                          <td>
                            @if($journalEntry->debit_title_id != NULL)
                              {{$journalEntry->debit->account_sub_group_name}}
                            @endif
                          </td>
                          <td>
                            @if($journalEntry->credit_title_id != NULL)
                              {{$journalEntry->credit->account_sub_group_name}}
                            @endif
                          </td>
                          <td>
                            @if($journalEntry->debit_amount>0)
                              {{$journalEntry->debit_amount}}
                            @endif
                          </td>
                          <td>
                            @if($journalEntry->credit_amount>0)
                              {{$journalEntry->credit_amount}}
                            @endif</td>
                        </tr>
                      @endforeach
                      <!--tr>
                        <td>06/22/2016</td>
                        <td href="../invoice/details.html">#2819374</td>
                        <td>For the month of June 2016</td>
                        <td>Accounts Receivable</td>
                        <td>Association Dues</td>
                        <td>PHP 480.00</td>
                        <td>PHP 480.00</td>
                        <td align="center">
                           <a href="#" role="button" class="btn btn-default">
                           <i class="fa fa-pencil"></i> 
                           </a>
                           <a href="#" role="button" class="btn btn-default">
                           <i class="fa fa-trash"></i> 
                           </a>
                        </td>
                      </tr>
                      <tr>
                        <td>06/22/2016</td>
                        <td>#2819374</td>
                        <td>For the month of June 2016</td>
                        <td>Cash</td>
                        <td>Association Dues</td>
                        <td>PHP 480.00</td>
                        <td>PHP 480.00</td>
                        <td align="center">
                           <a href="#" role="button" class="btn btn-default">
                           <i class="fa fa-pencil"></i> 
                           </a>
                           <a href="#" role="button" class="btn btn-default">
                           <i class="fa fa-trash"></i> 
                           </a>
                        </td>
                      </tr--> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection