<!DOCTYPE html>
<html lang="en">
  	<head>
    <style type="text/css">
         body {
              font-family: "Open Sans", "Arial", "Calibri", sans-serif;
              font-size: 12px;
            }
            .header p{
              margin: 5px;
            }
            th {
              background: #eee;
            }
            table, th, td {
              border: 1px solid #000;
              padding: 5px;
            }
        </style>
  	</head>
  	<style>
  		

  	</style>
  	<body>
       	<div class="header" style="display:inline-block; width:100%">
      		<div>
          		<p><strong>Somerset Homeowners Associations</strong></p>
              <p><strong> Somerset Homeowners Association</strong></p>
              <p><strong>B18 L22 Barrington, Somerset Ave, Pasig, Metro Manila</strong></p>
              <p><strong>(02) 470 0040</strong></p>
              <p><strong>somersetplace@gmail.com</strong></p>
              <p><strong>Receipt </strong></p>
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
              		<th><strong> Payee Information </strong></th>
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
                  <th> Quantity </th>
              		<th> Item </th>
              		<th> Description</th>
              		<th> Amount </th>
          		</tr>
          		@foreach($receipt->invoice->invoiceItems as $invItem)
          			<tr>
                    <td> {{$invItem->quantity}}  </td>
	              		<td> {{$invItem->item->item_name}}  </td>
	              		<td> {{$invItem->remarks}}  </td>
	              		<td> PHP {{$invItem->amount}}  </td>
	          		</tr>
          		
          		@endforeach
          		<tr>
              		<td colspan="3" align="right" style="padding-right:5px;"> Total Amount: </td>
              		<td>PHP {{$receipt->invoice->total_amount}}</td>
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