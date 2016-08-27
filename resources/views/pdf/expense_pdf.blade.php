<!DOCTYPE html>
<html lang="en">
  	<head>
	  <style>
	  		body {
				  font-family: Roboto, Helvetica, "Helvetica Neue", "Arial", sans-serif;
			  }
        .headline {
          text-align: center;
        }
        .headline img {
          max-width: 100px;
        }
        .headline h4 {
          margin: 0;
        }
        .title {
          background: #ddd;
          padding: 10px;
          margin-bottom: 0;

        }
        .details {
          margin-top: 0;
          background: #eee;
          margin-top: 0;
          padding: 10px;
        }
        table {
          width: 100%;
        }
        .receiver-info {
          width: 100%;
          background: #ddd;
          padding: 0;
          margin: 0;
        }
        .receiver-info h3 {
          padding: 10px;
          margin: 0;
        }
        .more-info p{
          background: #eee;
          margin: 0;
          padding: 10px;
        }
        .items {
          width: 100%;

        }
	  </style>
  	</head>
  	<body>
       	<div style="display:inline-block; width:100%">
      		<div class="headline">
              <img src="http://i.imgur.com/yt3S7Rv.png" alt="Somerset Place">
          		<h4><strong> Somerset Homeowners Association</strong></h4>
              <h4>B18 L22 Barrington, Somerset Ave, Pasig, Metro Manila</h4>
              <h4>(02) 470 0040</h4>
              <h4>somersetplace@gmail.com</h4>
      		</div>
      		<div>
          		<h3 class="title">Cash Voucher</h3>
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
  		<div style="background: #eee;">
      		<table>
          		<tr class="receiver-info">
              		<td><strong><h3> Receiver Information </h3></strong></td>
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
      		<table border="1" cellpadding="10" class="items" style="width:100%; border-collapse: collapse; border: 1px solid black;">
          		<tr style="background: #ddd;">
              		<th> Item </th>
              		<th> Description</th>
              		<th> Amount </th>
          		</tr>
          		@foreach($expense->expenseItems as $expItem)
          			<tr >
	              		<td> {{$expItem->item->item_name}}  </td>
	              		<td> {{$expItem->remarks}}  </td>
	              		<td> PHP {{$expItem->amount}}  </td>
	          		</tr>
          		
          		@endforeach
          		<tr>
              		<td colspan="2" align="right" style="padding-right:5px; background: #ddd;"> Total Amount: </td>
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