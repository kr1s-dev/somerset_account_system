@extends('master_layout.master_page_layout')
@section('content')
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="account-list" content="{{ $accountTitlesList }}">
   <meta name="type" content="{{ $type }}">
   <div class="">
         <div class="page-title">
            <div class="title_left">
               <h3><i class="fa fa-home"></i> Journal Entry</h3>
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
               <h2>Create a New Journal Entry</h2>
               <ul class="nav navbar-right panel_toolbox">
                  <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
               </ul>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
                  <!--form id="demo-form3" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                     <div class="form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Number <span class="required">*</span>
                     </label>
                     <div class="col-md-9 col-sm-6 col-xs-12">
                        <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date <span class="required">*</span>
                     </label>
                     <div class="col-md-9 col-sm-6 col-xs-12">
                        <input type="text" id="first-name" required="required" class="date-picker form-control col-md-7 col-xs-12">
                     </div>
                  </div>
               </form-->

               <form action="">
                     <table id="journal_entry_table"class="table table-striped ledger-table">
                     <thead>
                           <th>Dr/Cr</th>
                           <th>Account Title</th>
                           <th>Description</th>
                           <th>Dr Amount</th>
                           <th>Cr Amount</th>
                           <th>Actions</th>
                        </thead>
                        <tbody class="ledger-body">
                           <tr>
                                 <td>
                                    <select style="width: 95px;" name="cr_dr" class="form-control select1_single">
                                       <option value=""></option>
                                     <option value="DR">DR</option>
                                       <option value="CR">CR</option>
                                    </select>
                              </td>
                                 <td style="width: 20%;">
                                    <select name="account_title" id="" class="form-control select2_single">
                                       @foreach($accountTitlesList as $accountTitle)
                                          <option value="{{$accountTitle->id}}">{{$accountTitle->account_sub_group_name}}</option>
                                       @endforeach
                                    </select>
                                 </td>
                                 <td>
                                    <textarea class="form-control" id="explanation" cols="50" rows="2" style="resize: none;"></textarea>
                                 </td>
                                 <td>
                                    <input name="dr_amount" step="0.01" type="number" class="form-control" value="0.00" disabled>
                                 </td>
                                 <td>
                                    <input name="cr_amount" step="0.01" type="number" class="form-control" value="0.00" disabled>
                                 </td>
                                 <td>
                                    <button class="btn btn-default add-row">
                                       <i class="fa fa-plus"></i> Add
                                    </button>
                                    <!--button class="btn btn-default delete-row">
                                       <i class="fa fa-trash"></i> Delete
                                    </button-->
                                 </td>
                           </tr>
                        </tbody>
                     </table>
                     <table id="journal_total_amount" class="table table-striped">
                        <tbody>
                           <tr>
                                 <td style="width: 30%;">
                                    <button id="computeTotal" class="btn btn-primary" onsubmit="return false;">Total</button>
                                 </td>
                                 <td style="width: 22.1%;">PHP 0</td>
                                 <td style="width: 22.1%;">PHP 0</td>
                           
                           </tr>
                        </tbody>
                     </table>
                     <div class="form-group">
                        <label for="">Explanation</label>
                        <textarea class="form-control" name="" id="explanation" cols="30" rows="5"></textarea>
                     </div>
                     <div class="ln_solid"></div>
                        <div class="form-group pull-right">
                        <div class="col-md-12 col-sm-6 col-xs-12">
                           <a href="{{ route('account.index') }}" class="btn btn-primary">Cancel</a>
                              <!--button type="submit" class="btn btn-primary">Cancel</button-->
                              <button id="sbmt_jour_entry" type="submit" class="btn btn-success">Submit</button>
                        </div>
                        </div>
                     </form>
               </div>
            </div>
         </div>
   </div>
@endsection
