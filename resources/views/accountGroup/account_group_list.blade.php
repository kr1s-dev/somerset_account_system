@extends('master_layout.master_page_layout')
@section('content')
    <div class="">
        <div class="page-title">
          	<div class="title_left">
            	<h3><i class="fa fa-users"></i> Account Groups</h3>
          	</div>
        </div>

        <div class="clearfix"></div>

        <div class="col-md-12 col-sm-12 col-xs-12">
	        <div class="x_panel">
	          	<div class="x_title">
		            <h2>List of All Account Groups</h2>
		            <ul class="nav navbar-right panel_toolbox">
		           
		              	<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		              	</li>
		            </ul>
		            <div class="clearfix"></div>
	         	</div>
	        	<div class="x_content">
	            	<div class="pull-right">
	              		<a href="{{ route('accountgroup.create') }}" class="btn btn-primary">
	                		<i class="fa fa-plus"></i> Create New Account Group
	              		</a>
	            	</div>
	            	<div class="clearfix"></div>
	            	<br>
	            </div>
	            <table id="datatable" class="table table-striped table-bordered">
	              	<thead>
		                <tr>
		                  	<th>Account Group Name</th>
		                  	<th>Description</th>
		                  	<th>Date Created</th>
		                  	<th>Actions</th>
		                </tr>
	              	</thead>
	              	<tbody>
		                @foreach($accountGroupList as $accountGroup)
			          		<tr>
				          		<td><a href="{{ route('accountgroup.show',$accountGroup->id) }}">{{ $accountGroup -> account_group_name }}</a></td>
				          		<td>{{ $accountGroup -> description }}</td>
				          		<td> {{ $accountGroup -> created_at }} </td>
				          		
				          		<td align="center">
					                <a href="{{ route('accountgroup.edit',$accountGroup->id) }}" role="button" class="btn btn-default">
					                	<i class="fa fa-pencil"></i> 
					                </a>
					                {!! Form::model($accountGroup, ['method'=>'DELETE','action' => ['accountGroup\AccountGroupController@destroy',$accountGroup->id] , 'class' => 'form-horizontal form-label-left']) !!}
					                    <button type="submit" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </button>
					               	{!! Form::close() !!}
					            </td>
				        	</tr>
			          	@endforeach
	              	</tbody>
	            </table>
	          </div>
	        </div>
	    </div>
	</div>
@endsection