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
               <h2>List of All Accounts</h2>
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
                        <th>Name</th>
                        <th>Financial Year Start Date</th>
                        <th>Financial Year End Date</th>
                        <th>O/P Balance</th>
                        <th>C/L Balance</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($eAccountDetailsList as $eAccountDetail)
                        <tr>
                           <td><a href="{{ route('account.show',$eAccountDetail->id) }}"><strong>{{$eAccountDetail->account_name}}</strong></a></td>
                           <td>{{date('Y-m-d',strtotime($eAccountDetail->accounting_year_start_date))}}</td>
                           <td>{{date('Y-m-d',strtotime($eAccountDetail->accounting_year_end_date))}}</td>
                           <td>PHP {{$eAccountDetail->o_p_balance}}</td>
                           <td>PHP {{$eAccountDetail->c_l_balance}}</td>
                           <td align="center">
                              <a href="{{ route('account.edit',$eAccountDetail->id) }}" role="button" class="btn btn-default">
                              <i class="fa fa-pencil"></i> 
                              </a>
                              <!--a href="#" role="button" class="btn btn-default">
                              <i class="fa fa-trash"></i> 
                              </a-->
                           </td>
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