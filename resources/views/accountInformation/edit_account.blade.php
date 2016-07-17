@extends('master_layout.master_page_layout')
@section('content')
<!-- page content -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
	<div class="">
   	<div class="page-title">
      	<div class="title_left">
         	<h3><i class="fa fa-home"></i> Account</h3>
      	</div>
   	</div>
   	<div class="clearfix"></div>
   	<div class="col-md-12 col-sm-12 col-xs-12">
      	<div class="x_panel">
         	<div class="x_title">
            		<h2><strong>Update Account</strong> | Account Details</h2>
            		<ul class="nav navbar-right panel_toolbox">
               		<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
               		</li>
            		</ul>
            		<div class="clearfix"></div>
         	</div>
         	<div class="x_content">
               {!! Form::model($nAccountDetail,['method'=>'PATCH','action'=> ['accountInformation\AccountInformationController@update',$nAccountDetail->id],'class'=>'form-horizontal form-label-left']) !!}
                  @include('accountInformation.account_form',['submitButton'=>'Update Account Detail']);
               {!! Form::close() !!}
         	</div>
      	</div>
   	</div>
	</div>
<!-- page content -->
@endsection