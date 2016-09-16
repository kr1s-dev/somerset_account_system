@extends('master_layout.master_page_layout')
@section('content')
    <div class="">
        <div class="page-title">
          	<div class="title_left">
            	<h3><i class="fa fa-table"></i> Account Titles</h3>
          	</div>
        </div>

        <div class="clearfix"></div>

        <div class="col-md-12 col-sm-12 col-xs-12">
	        <div class="x_panel">
	          	<div class="x_title">
		            <h2>List of All Account Titles</h2>
		            <ul class="nav navbar-right panel_toolbox">
		           
		              	<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		              	</li>
		            </ul>
		            <div class="clearfix"></div>
	         	</div>
	        	<div class="x_content">
	            	<div class="pull-right">
	              		<a href="{{ route('accounttitle.create') }}" class="btn btn-primary">
	                		<i class="fa fa-plus"></i> Create New Account Title
	              		</a>
	            	</div>
	            	<div class="clearfix"></div>
	            	<br>
	            </div>
	            <table id="datatable" class="table table-striped table-bordered" border="1">
	            	<tbody>
	            		<tr>
	            			<td colspan="2"><strong>ACCOUNT TITLES</strong></td>
	            			<td width="20%"> <strong>OPENING BALANCE</strong></td>
	            		</tr>
	            		<tr>
	            			<td colspan="3"><strong>ASSETS</strong></td>
	            		</tr>
	            		@foreach($taccountGroupList as $accountGroup)
	            			@if(strpos($accountGroup->account_group_name, 'Asset'))
		            			<tr>
			            			<td colspan="3" style="text-indent: 30px;"><strong>{{$accountGroup->account_group_name}}</strong></td>
			            		</tr>	
		            			@foreach($accountGroup->accountTitles as $accountTitle)
		            				@if(is_null($accountTitle->account_title_id))
		            					<tr>
			            					<td colspan="2" style="text-indent: 50px;">
			            						<a href="{{ route('accounttitle.show',$accountTitle->id) }}">
			            							{{$accountTitle->account_sub_group_name}}
			            						</a>
			            					</td>
			            					<td >
			            						{{$accountTitle->opening_balance}}
			            					</td>
			            				</tr>
			            				@foreach($accountTitle->accountTitleChildren as $accountTitlechild)
			            					<tr>
				            					<td colspan="2" style="text-indent: 70px;">
				            						<a href="{{ route('accounttitle.show',$accountTitlechild->id) }}">
				            							{{$accountTitlechild->account_sub_group_name}}
				            						</a>
				            					</td>
				            					<td >
				            						
				            					</td>
				            				</tr>
			            				@endforeach
		            				@endif
		            			@endforeach
		            			<tr>
		            				<td colspan="3" style="text-indent: 50px;">
		            					<a href="accounttitle/create/group/{{$accountGroup->id}}"><strong><u><em>Add {{$accountGroup->account_group_name}}</em></u></strong></a>
		            				</td>
		            			</tr>
	            			@endif
	            		@endforeach
	            		<tr>
	            			<td colspan="3"><strong>LIABILITIES</strong></td>
	            		</tr>
	            		@foreach($taccountGroupList as $accountGroup)
	            			@if(strpos($accountGroup->account_group_name, 'Liabilities'))
	            				<tr>
		            				<td colspan="3" style="text-indent: 30px;"><strong>{{$accountGroup->account_group_name}}</strong></td>
			            		</tr>	
		            			@foreach($accountGroup->accountTitles as $accountTitle)
		            				@if(is_null($accountTitle->account_title_id))
		            					<tr>
			            					<td colspan="2" style="text-indent: 50px;">
			            						<a href="{{ route('accounttitle.show',$accountTitle->id) }}">
			            							{{$accountTitle->account_sub_group_name}}
			            						</a>
			            					</td>
			            					<td>
			            						{{$accountTitle->opening_balance}}
			            					</td>
			            				</tr>
			            				@foreach($accountTitle->accountTitleChildren as $accountTitlechild)
			            					<tr>
				            					<td colspan="2" style="text-indent: 70px;">
				            						<a href="{{ route('accounttitle.show',$accountTitlechild->id) }}">
				            							{{$accountTitlechild->account_sub_group_name}}
				            						</a>
				            					</td>
				            					<td >
				            						{{$accountTitle->opening_balance}}
				            					</td>
				            				</tr>
			            				@endforeach
		            				@endif
		            			@endforeach
		            			<tr>
		            				<td colspan="3" style="text-indent: 50px;">
		            					<a href="accounttitle/create/group/{{$accountGroup->id}}"><strong><u><em>Add {{$accountGroup->account_group_name}}</em></u></strong></a>
		            				</td>
		            			</tr>
	            			@endif
	            		@endforeach
	            		<tr>
	            			<td colspan="3"><strong>OWNERS EQUITY</strong></td>
	            		</tr>
	            		@foreach($taccountGroupList as $accountGroup)
	            			@if(strpos($accountGroup->account_group_name, 'Equity'))
		            			@foreach($accountGroup->accountTitles as $accountTitle)
		            				@if(is_null($accountTitle->account_title_id))
		            					<tr>
			            					<td colspan="2" style="text-indent: 50px;">
			            						<a href="{{ route('accounttitle.show',$accountTitle->id) }}">
			            							{{$accountTitle->account_sub_group_name}}
			            						</a>
			            					</td>
			            					<td>
			            						{{$accountTitle->opening_balance}}
			            					</td>
			            				</tr>
			            				@foreach($accountTitle->accountTitleChildren as $accountTitlechild)
			            					<tr>
				            					<td colspan="2" style="text-indent: 70px;">
				            						<a href="{{ route('accounttitle.show',$accountTitlechild->id) }}">
				            							{{$accountTitlechild->account_sub_group_name}}
				            						</a>
				            					</td>
				            					<td >
				            						{{$accountTitle->opening_balance}}
				            					</td>
				            				</tr>
			            				@endforeach
		            				@endif
		            			@endforeach
		            			<tr>
		            				<td colspan="3" style="text-indent: 50px;">
		            					<a href="accounttitle/create/group/{{$accountGroup->id}}"><strong><u><em>Add {{$accountGroup->account_group_name}}</em></u></strong></a>
		            				</td>
		            			</tr>
	            			@endif
	            		@endforeach
	            		<tr>
	            			<td colspan="3"><strong>REVENUES</strong></td>
	            		</tr>
	            		@foreach($taccountGroupList as $accountGroup)
	            			@if($accountGroup->account_group_name == 'Revenues')
            					@foreach($accountGroup->accountTitles as $accountTitle)
		            				@if(is_null($accountTitle->account_title_id))
		            					<tr>
			            					<td colspan="2" style="text-indent: 50px;">
			            						<a href="{{ route('accounttitle.show',$accountTitle->id) }}">
			            							{{$accountTitle->account_sub_group_name}}
			            						</a>
			            					</td>
			            					<td>
			            						
			            					</td>
			            				</tr>
			            				@foreach($accountTitle->accountTitleChildren as $accountTitlechild)
			            					<tr>
				            					<td colspan="2" style="text-indent: 70px;">
				            						<a href="{{ route('accounttitle.show',$accountTitlechild->id) }}">
				            							{{$accountTitlechild->account_sub_group_name}}
				            						</a>
				            					</td>
				            					<td >
				            						
				            					</td>
				            				</tr>
			            				@endforeach
		            				@endif
		            			@endforeach
		            			<tr>
		            				<td colspan="3" style="text-indent: 50px;">
		            					<a href="accounttitle/create/group/{{$accountGroup->id}}"><strong><u><em>Add {{$accountGroup->account_group_name}}</em></u></strong></a>
		            				</td>
		            			</tr>
	            			@endif
	            			
	            		@endforeach
	            		<tr>
	            			<td colspan="3"><strong>EXPENSES</strong></td>
	            		</tr>
	            		@foreach($taccountGroupList as $accountGroup)
	            			@if($accountGroup->account_group_name == 'Expenses')
            					@foreach($accountGroup->accountTitles as $accountTitle)
		            				@if(is_null($accountTitle->account_title_id))
		            					<tr>
			            					<td colspan="2" style="text-indent: 50px;">
			            						<a href="{{ route('accounttitle.show',$accountTitle->id) }}">
			            							{{$accountTitle->account_sub_group_name}}
			            						</a>
			            					</td>
			            					<td>
			            						
			            					</td>
			            				</tr>
			            				@foreach($accountTitle->accountTitleChildren as $accountTitlechild)
			            					<tr>
				            					<td colspan="2" style="text-indent: 70px;">
				            						<a href="{{ route('accounttitle.show',$accountTitlechild->id) }}">
				            							{{$accountTitlechild->account_sub_group_name}}
				            						</a>
				            					</td>
				            					<td >
				            						
				            					</td>
				            				</tr>
			            				@endforeach
		            				@endif
		            			@endforeach
		            			<tr>
		            				<td colspan="3" style="text-indent: 50px;">
		            					<a href="accounttitle/create/group/{{$accountGroup->id}}"><strong><u><em>Add {{$accountGroup->account_group_name}}</em></u></strong></a>
		            				</td>
		            			</tr>
	            			@endif
	            		@endforeach
	            	</tbody>
	            </table>
	            
	          </div>
	        </div>
	    </div>
	</div>
@endsection