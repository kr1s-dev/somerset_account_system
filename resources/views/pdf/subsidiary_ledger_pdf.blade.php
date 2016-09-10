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
       	<div class="header" align="center">
		     <p><strong>Somerset Homeowners Association</strong></p>
		     <p><strong>Subsidiary Ledger ({{$type}})</strong> </p>
		     <p><strong>For 
		     	@if(empty($monthFilter))
		     		Year End {{$yearFilter}}
		     	@else
		     		Month End {{$monthArray[$monthFilter]}},{{$yearFilter}}
		     	@endif</strong>
		     </p>
		</div>
		<hr/>
		<table style="width:100%; border-collapse: collapse; text-align:center;" border="1">
			@if($type=='homeowner')
				<thead>
					<tr>
						<th>Receipt #</th>
						<th>Payee</th>
						<th>Amount</th>
						<th>Covering Month/s</th>
						<th>Payment Type</th>
						<th>Subject To VAT</th>
						<th>Non VAT Sales</th>
						<th>VATable Sales</th>
						<th>Output VAT</th>
					</tr>
				</thead>
				<tbody>
					@if(empty($listOfItem))
	    				<tr><td colspan="9" align="center"><em><strong> No Records Found </strong></em></td></tr>
	    			@else
	    				@foreach($listOfItem as $key => $value)
	          				@foreach($value as $val)
	          				<tr>
	          					<td><em><strong>{{sprintf("%'.07d\n", $val->invoice->receipt->receipt_no)}}</strong></em></td>
	          					<td>{{$key}}</td>
	          					<td>PHP {{number_format($val->amount,2)}}</td>	
	          					<td>{{$val->remarks}}</td>
	          					<td>{{$val->item->item_name}}</td>
	          					@if($val->item->subject_to_vat)
	      							<td>YES</td>
	      							<td>-</td>
	      							<td>PHP {{number_format(($val->amount-($val->amount * ($val->item->vat_percent/100))),2)}}</td>	
	      							<td>PHP {{number_format(($val->amount * ($val->item->vat_percent/100)),2)}}</td>	
	      						@else
	      							<td>NO</td>
	      							<td>PHP {{number_format($val->amount,2)}}</td>
	      							<td>-</td>	
	      							<td>-</td>	
	      						@endif
	              			</tr>
	              			@endforeach
	          			@endforeach
	    			@endif
	    		</tbody>
	    	@elseif($type=='vendor')
	    		<thead>
	                <tr>
	                	<th>Date of Check</th>
	                	<th>Payee</th>
	                	<th>Paid To</th>
	                	<th>Particulars</th>
	                  	<th>Cash Voucher #</th>
	                  	<th>Amount</th>
	                </tr>
	          	</thead>
	          	<tbody>
	          		@if(empty($listOfItem))
	    				<tr><td colspan="6" align="center"><em><strong> No Records Found </strong></em></td></tr>
	    			@else
	    				@foreach($listOfItem as $key => $value)
	          				@foreach($value as $val)
	          				<tr>
	          					<td>{{date('m-d-y',strtotime($val->created_at))}}</td>
	          					<td>
	          						@if($val->userCreateInfo->homeowner_id!=NULL)
	          							{{$val->userCreateInfo->homeOwner->first_name}}
	          							{{$val->userCreateInfo->homeOwner->middle_name}}
	          							{{$val->userCreateInfo->homeOwner->last_name}}
	          						@else
	          							{{$val->userCreateInfo->first_name}}
	          							{{$val->userCreateInfo->middle_name}}
	          							{{$val->userCreateInfo->last_name}}
	          						@endif
	          					</td>
	          					<td>{{$key}}</td>
	          					<td>{{$val->item->item_name}}</td>	
	          					<td>{{sprintf("%'.07d\n", $val->expense->id)}}</strong></em></td>
	              				<td>PHP {{number_format($val->amount,2)}}</td>
	              				
	              			</tr>
	              			@endforeach
	          			@endforeach
	    			@endif
	          	</tbody>
			@endif
	  	</table>
  	</body>
</html>