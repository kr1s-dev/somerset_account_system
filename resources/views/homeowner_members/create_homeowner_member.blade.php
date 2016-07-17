@extends('master_layout.master_page_layout')
@section('content')
   <div class="">
      	<div class="page-title">
         	<div class="title_left">
            	<h3><i class="fa fa-users"></i> Homeowner Member</h3>
         	</div>
      	</div>
      	<div class="clearfix"></div>
      	<div class="col-md-12 col-sm-12 col-xs-12">
         	<div class="x_panel">
            	<div class="x_title">
               	<h2><strong>Create a New Homeowner Member</strong> | Personal Information</h2>
               	<ul class="nav navbar-right panel_toolbox">
                  	<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  	</li>
               	</ul>
               	<div class="clearfix"></div>
            </div>
            <div class="x_content">
               	<div class="col-md-9 col-md-offset-3">
                 	<h4>All fields marked with * are required</h4>
               	</div>
               	{!! Form::open(['url'=>'homeownermembers','method'=>'POST','class'=>'form-horizontal form-label-left']) !!}
                    @include('homeowner_members.homeowner_member_form',['submitButton'=>'Register']);
               	{!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
@endsection