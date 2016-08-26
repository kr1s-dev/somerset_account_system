<!DOCTYPE html>
<html lang="en">
  	<head>
  	</head>
  	<style>
  		

  	</style>
  	<body>
       	<div style="display:inline-block; width:100%">
      		<div>
          		<h2><strong>Somerset Homeowners Associations</strong></h2>
      		</div>
      		<div style="float:right;">
          		<h2>Cash Receipt</h2>
      		</div>
  		</div>
  		<hr/>
  
  		<div style="display:inline-block; width:100%">
      	<div style="float:left;">
          	<strong>Receipt #: {{sprintf("%'.07d\n",$receipt->receipt_no)}}</strong>
      	</div>
      		<div style="float:right;">
          		Date Paid: {{date('F d, Y',strtotime($receipt->created_at))}}
      		</div>
  		</div>
  		<div>
      		<strong>Invoice Referrence #: {{sprintf("%'.07d\n",$invoiceNumber)}}</strong>
  		</div>
  		<br/>
  		<div>
      		<table>
          		<tr>
              		<td><strong> Payee Information </strong></td>
          		</tr>
          		<tr>
              		<td> Name:  {{$receipt->invoice->homeOwner->first_name}} {{$receipt->invoice->homeOwner->middle_name}} {{$receipt->invoice->homeOwner->last_name}}</td>
          		</tr>
          		<tr>
              		<td> Address:  {{$receipt->invoice->homeOwner->member_address}} </td>
          		</tr>
          		<tr>
              		<td> Contact Number:  {{$receipt->invoice->homeOwner->member_mobile_no}}</td>
          		</tr>
          		<tr>
              		<td> Email Address:  {{$receipt->invoice->homeOwner->member_email_address}}</td>
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
          		@foreach($receipt->invoice->invoiceItems as $invItem)
          			<tr>
	              		<td style="padding:0px 10px 0px 10px;"> {{$invItem->item->item_name}}  </td>
	              		<td style="padding:0px 10px 0px 10px;"> {{$invItem->remarks}}  </td>
	              		<td style="padding:0px 10px 0px 10px;"> PHP {{$invItem->amount}}  </td>
	          		</tr>
          		
          		@endforeach
          		<tr>
              		<td colspan="2" align="right" style="padding-right:5px;"> Total Amount: </td>
              		<td style="padding:0px 10px 0px 10px;">PHP {{$receipt->invoice->total_amount}}</td>
          		</tr>
      		</table>
  		</div>
  		<br/><br/>
  		<div style="margin-left: 60%;">
  			_______________________________ <br/>
  			<div align="center" style="width:90%">
  				@if($receipt->cashier->home_owner_id != NULL)
  					{{$receipt->cashier->homeOwner->first_name}} {{$receipt->cashier->homeOwner->middle_name}} {{$receipt->cashier->homeOwner->last_name}}
  				@else
  					{{$receipt->cashier->first_name}} {{$receipt->cashier->middle_name}} {{$receipt->cashier->last_name}}
  				@endif
  			</div>
  		</div>
  	</body>
</html>