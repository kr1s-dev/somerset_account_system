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
  	<body>
       	<div style="display:inline-block; width:100%">
      		<div class="header">
          		<p><strong> Somerset Homeowners Association</strong></p>
              <p><strong>B18 L22 Barrington, Somerset Ave, Pasig, Metro Manila</strong></p>
              <p><strong>(02) 470 0040</strong></p>
              <p><strong>somersetplace@gmail.com</strong></p>
      		</div>
      		<div>
          		<h3>Cash Voucher</h3>
      		</div>
  		</div>
  		<div class="details" style="width:100%">
      	<div>
          	<strong>Cash Voucher #: {{sprintf("%'.07d\n",$expenseNumber)}}</strong>
      	</div>
      		<div style="float:right;">
          		Date filed: {{date('F d, y',strtotime($expense->created_at))}}
      		</div>
  		</div>
  		<div>
      		<table>
          		<tr class="receiver-info">
              		<th><strong>Receiver Information</th>
          		</tr>
          		<tr class="more-info">
                @if($expense->paid_to != NULL)
                  <p>{{$expense->paid_to}}</p>
                @else
                  <p>{{$expense->vendor->vendor_name}}</p>
                  <p>{{$expense->vendor->vendor_contact_person}}</p>
                @endif
          		</tr>
      		</table>
  		</div>
  		<br/>
  		<div>
      		<table>
          		<tr>
              		<th> Item </th>
              		<th> Description</th>
              		<th> Amount </th>
          		</tr>
          		@foreach($expense->expenseItems as $expItem)
          			<tr>
	              		<td> {{$expItem->item->item_name}}  </td>
	              		<td> {{$expItem->remarks}}  </td>
	              		<td> PHP {{$expItem->amount}}  </td>
	          		</tr>
          		
          		@endforeach
          		<tr>
              		<td colspan="2" align="right" style="padding-right:5px; background: #ddd;"> Total Amount: </td>
              		<td>PHP {{$expense->total_amount}}</td>
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