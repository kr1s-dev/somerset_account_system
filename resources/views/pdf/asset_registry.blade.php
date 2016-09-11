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
		     <p>Asset Registry</p>
		     <p>{{date('F')}}, {{date('Y')}} </p>
		</div>
		<hr/>
		<table style="width:100%; border-collapse: collapse; text-align:center;">
		        <thead>
                 <tr>
                  	<th>Item Name</th>
                  	<th>Quantity</th>
                  	<th>Monthly Depreciation</th>
                  	<th>Accumulated Depreciation</th>
                  	<th>Remaining Months</th>
                  	<th>Net Amount</th>
                </tr>
          	</thead>
          	<tbody>
          		@if(empty($assetItemList))
    				<tr><td colspan="5" align="center"><em><strong> No Records Found </strong></em></td></tr>
    			@else
    				@foreach($assetItemList as $assetItem)
          				<tr>
          					<td>{{$assetItem->item_name}}</td>
          					<td>{{number_format($assetItem->quantity,2)}}</td>
              				<td>PHP {{number_format($assetItem->monthly_depreciation,2)}}</td>
              				<td>PHP {{number_format($assetItem->accumulated_depreciation,2)}}</td>	
              				<td>{{$assetItem->useful_life}} mo/s</td>
              				<td>{{$assetItem->net_value}}</td>	
              			</tr>
          			@endforeach
    			@endif
          	</tbody>
  		</table>
  	</body>
</html>