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
          		<h2>Invoice</h2>
      		</div>
  		</div>
  		<hr/>
  
  		<div style="display:inline-block; width:100%">
      	<div style="float:left;">
          	<strong>Invoice #: {{sprintf("%'.07d\n",$invoiceNumber)}}</strong>
      	</div>
      		<div style="float:right;">
          		Payment Due Date: {{date('F d, Y',strtotime($invoice->payment_due_date))}}
      		</div>
  		</div>
  		<br/><br/>
  		<div>
      		<table>
          		<tr>
              		<td><strong> Payee Information </strong></td>
          		</tr>
          		<tr>
              		<td> Name:  {{$invoice->homeOwner->first_name}} {{$invoice->homeOwner->middle_name}} {{$invoice->homeOwner->last_name}}</td>
          		</tr>
          		<tr>
              		<td> Address:  {{$invoice->homeOwner->member_address}} </td>
          		</tr>
          		<tr>
              		<td> Contact Number:  {{$invoice->homeOwner->member_mobile_no}}</td>
          		</tr>
          		<tr>
              		<td> Email Address:  {{$invoice->homeOwner->member_email_address}}</td>
          		</tr>
      		</table>
  		</div>
  		<br/>
  		<div>
      		<table border="1" style="width:100%; border-collapse: collapse; border: 1px solid black;">
          		<tr>
                  <th style="padding:0px 10px 0px 10px;"> Quantity </th>
              		<th style="padding:0px 10px 0px 10px;"> Item </th>
              		<th style="padding:0px 10px 0px 10px;"> Description</th>
              		<th style="padding:0px 10px 0px 10px;"> Amount </th>
          		</tr>
              
          		@foreach($invoice->invoiceItems as $invItem)
          			<tr>
                    <td style="padding:0px 10px 0px 10px;"> {{$invItem->quantity}}  </td>
	              		<td style="padding:0px 10px 0px 10px;"> {{$invItem->item->item_name}}  </td>
	              		<td style="padding:0px 10px 0px 10px;"> {{$invItem->remarks}}  </td>
	              		<td style="padding:0px 10px 0px 10px;"> PHP {{$invItem->amount}}  </td>
	          		</tr>
          		
          		@endforeach
          		<tr>
              		<td colspan="3" align="right" style="padding-right:5px;"> Total Amount: </td>
              		<td style="padding:0px 10px 0px 10px;">PHP {{$invoice->total_amount}}</td>
          		</tr>
      		</table>
  		</div>
  		<br/><br/>
  		<div style="margin-left: 60%;">
  			_______________________________ <br/>
  			<div align="center" style="width:90%">
  				@if($invoice->user->home_owner_id != NULL)
  					{{$invoice->user->homeOwner->first_name}} {{$invoice->user->homeOwner->middle_name}} {{$invoice->user->homeOwner->last_name}}
  				@else
            {{$invoice->user->first_name}} {{$invoice->user->middle_name}} {{$invoice->user->last_name}} 
  				@endif
  			</div>
  		</div>
  	</body>
</html>