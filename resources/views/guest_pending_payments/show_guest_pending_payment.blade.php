@extends('master_layout.master_guess_page_layout')
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
          <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Description</th>
                <th>Amount</th>
                <th>Due Date</th>
                <th>Date Created</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Association Dues</td>
                <td>400</td>
                <td>07/29/2016</td>
                <td>07/22/2016</td>
              </tr>
              <tr>
                <td>Association Dues</td>
                <td>400</td>
                <td>06/29/2016</td>
                <td>06/22/2016</td>
              </tr>
              <tr>
                <td>Association Dues</td>
                <td>400</td>
                <td>05/29/2016</td>
                <td>05/22/2016</td>
              </tr>
              <tr>
                <td>Association Dues</td>
                <td>400</td>
                <td>04/29/2016</td>
                <td>04/22/2016</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection