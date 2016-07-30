@extends('master_layout.master_page_layout')
@section('content')
	<div class="">
   	<div class="page-title">
      	<div class="title_left">
         	<h3><i class="fa fa-bullhorn"></i> Announcements</h3>
      	</div>
   	</div>
   	<div class="clearfix"></div>

   	<div class="col-md-12 col-sm-12 col-xs-12">
      	<div class="x_panel">
         	<div class="x_title">
         		<h2>Create a New Announcement</h2>
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
               {!! Form::model($announcement, ['method'=>'PATCH','action' => ['announcement\AnnouncementController@update',$announcement->id] , 'class' => 'form-horizontal form-label-left']) !!}
                   @include('announcement.announcement_form',['submitButton'=>'Update Announcement']);
               {!! Form::close() !!}
            </div>
     	   </div>
   	</div>
   </div>
@endsection