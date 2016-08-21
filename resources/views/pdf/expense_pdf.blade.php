<!DOCTYPE html>
<html lang="en">
  	<head>
  	</head>
  	<body>
       	<div style="display:inline-block; width:100%">
      		<div>
          		<h2><strong>Somerset Homeowners Associations</strong></h2>
      		</div>
      		<div style="float:right;">
          		<h2>Cash Voucher</h2>
      		</div>
  		</div>
  		<hr/>
  
  		<div style="display:inline-block; width:100%">
      	<div style="float:left;">
          	<strong>Cash Voucher #: {{sprintf("%'.07d\n",$expenseNumber)}}</strong>
      	</div>
      		<div style="float:right;">
          		Date filed: {{date('F d, y',strtotime($expense->created_at))}}
      		</div>
  		</div>
  		<br/><br/>
  		<div>
      		<table>
          		<tr>
              		<td><strong> Receiver Information </strong></td>
          		</tr>
          		<tr>
              		<td> Name:  {{$expense->paid_to}}</td>
          		</tr>
      		</table>
  		</div>
  		<br/>
  		<div>
      		<table border="1" style="width:100%; border-collapse: collapse; border: 1px solid black;">
          		<tr>
              		<th style="padding:0px 10px 0px 10px;"> Item </th>
              		<th style="padding:0px 10px 0px 10px;"> Description</th>
              		<th style="padding:0px 10px 0px 10px;"> Amount </th>
          		</tr>
          		@foreach($expense->expenseItems as $expItem)
          			<tr>
	              		<td style="padding:0px 10px 0px 10px;"> {{$expItem->accountTitle->account_sub_group_name}}  </td>
	              		<td style="padding:0px 10px 0px 10px;"> {{$expItem->remarks}}  </td>
	              		<td style="padding:0px 10px 0px 10px;"> PHP {{$expItem->amount}}  </td>
	          		</tr>
          		
          		@endforeach
          		<tr>
              		<td colspan="2" align="right" style="padding-right:5px;"> Total Amount: </td>
              		<td style="padding:0px 10px 0px 10px;">PHP {{$expense->total_amount}}</td>
          		</tr>
      		</table>
  		</div>
  		<br/><br/>
  		<div style="margin-left: 60%;">
  			_______________________________ <br/>
  			<div align="center" style="width:90%">
  				@if($expense->user->home_owner_id != NULL)
  					{{$expense->user->homeOwner->first_name}} {{$expense->user->homeOwner->middle_name}} {{$expense->user->homeOwner->last_name}}
  				@else
            {{$expense->user->first_name}} {{$expense->user->middle_name}} {{$expense->user->last_name}} 
  				@endif
  			</div>
  		</div>
  	</body>
</html>