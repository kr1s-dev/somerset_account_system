<!DOCTYPE html>
<html lang="en">
  	<head>
  	</head>
  	<body>
       	<div align="center">
		     <p><strong>Somerset Homeowners Association</strong></p>
		     <p>Statement of Cash Flow </p>
		     <p>For the Year Ended {{date('M t',strtotime($yearFilter . '-'. '12'))}}, {{$yearFilter}}
		     </p>
		</div>
		<hr/>
		<table style="width:100%; border-collapse: collapse;">
          	<thead>
                <tr>
                  	<th colspan="3" align="left"><h3>Cash Flow from Operating Activities</h3></th>
                </tr>
          	</thead>
          	<tbody>
          		<tr>
          			<td colspan="2">Cash Received from Customers </td>
          			<td align="right"> PHP {{number_format($incTotalSum-$arBalance,2)}}</td>
          		</tr>
          		@if(count($expenseList)>0)
          			<tr>
          				<td colspan="3">Cash Payments For: </td>
              		</tr>
              		@foreach($expenseList as $key=>$value)
              			@if($value > 0)
              				<tr>
	              				<td>{{str_replace(strpos($key, 'Expense')?'Expense':'Expenses', '', $key)}}</td>
	              				<td align="right">PHP {{number_format($value,2)}}</td>
	              				<td></td>
	              			</tr>
              			@endif
              		@endforeach
          		@endif
          		
          	</tbody>
          	<thead>
                <tr>
                  	<th colspan="3" align="left"><h3>Cash Flow from Investing Activities</h3></th>
                </tr>
          	</thead>
          	<tbody>
          		@if(count($investmentList)<=0)
          			<tr>
          				<td colspan="3" align="center"><i><strong>No Activity Found</strong></i></td>
          			</tr>
          		@else
          			@foreach($investmentList as $key => $value)
              			@if($value != 0)
              				<tr>
	              				<td>Acquisition of {{$key}}</td>
	              				<td align="right">PHP {{number_format($value,2)}}</td>
	              				<td></td>
	              			</tr>
              			@endif
              		@endforeach
          		@endif
          	</tbody>
          	<thead>
                <tr>
                  	<th colspan="3" align="left"><h3>Cash Flow from Financing Activities</h3></th>
                </tr>
          	</thead>
          	<tbody>
          		@if(count($financingList)<=0)
          			<tr>
          				<td colspan="3" align="center"><i><strong>No Activity Found</strong></i></td>
          			</tr>
          		@else
          			@foreach($financingList as $key => $value)
              			@if($value != 0)
              				<tr>
	              				<td colspan="2">{{$key}}</td>
	              				<td align="right">PHP {{number_format($value,2)}}</td>
	              			</tr>
              			@endif
              		@endforeach
          		@endif
          	</tbody>
          	<thead>
                <tr>
                  	<td colspan="2"><h3>Total Cash In Hand</h3></td>
                  	<td align="right">PHP {{number_format($totalCashInHand,2)}}</td>
                </tr>
          	</thead>
        </table>
  	</body>
</html>