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
		     <p><strong>Income Statement </strong></p>
		     <p><strong>For 
		     	@if(empty($monthFilter))
		     		Year End {{$yearFilter}}
		     	@else
		     		Month End {{$monthArray[$monthFilter]}},{{$yearFilter}}
		     	@endif</strong>
		     </p>
		</div>
		<hr/>
		<table style="width:100%; border-collapse: collapse;">
		    <tr>
		        <th colspan="3" align="left">Revenues</th>
		    </tr>
		    <!-- income items -->
		    @foreach($incomeItemsList as $key => $value)
			    <tr>
			        <td align="center" width="30%"> {{$key}}</td>
			        <td  width="35%"></td>
			        <td align="right" width="35%">PHP {{number_format($value,2)}}</td>
			    </tr>
		    @endforeach
		    <!-- income items -->
		    <tr>
		        <td width="30%"> <strong>Total Revenue</strong></td> 
		        <td  width="35%"></td>
		        <td align="right" width="35%">PHP {{number_format($incTotalSum,2)}}</td>      
		    </tr>
		    <tr>
		        <!-- For margin -->
		        <td colspan="3"><br/></td> 
		    </tr>
		    <tr>
		        <th colspan="3" align="left"><strong>Expenses</strong></th>
		    </tr>
		    <!-- Expense Items -->
		    @foreach($expenseItemsList as $key => $value)
			    <tr>
			        <td align="center" width="30%"> {{$key}}</td>
			        <td align="right" width="35%">PHP {{number_format($value,2)}}</td>
		        <td width="35%"></td>
			    </tr>
		    @endforeach
		    <!-- Expense Items -->
		    <tr>
		        <td width="30%"> <strong>Total Expense</strong></td> 
		        <td align="right" width="35%">PHP {{number_format($expTotalSum,2)}}</td>
		        <td width="35%"></td>      
		    </tr>
		    <tr>
		        <!-- For margin -->
		        <td colspan="3"><br/></td> 
		    </tr>
		      
		    <tr>
		        <td width="30%"> <strong>Net Income(Loss)</strong></td> 
		        <td width="35%"></td>
		        <td align="right" width="35%">PHP {{ number_format($incTotalSum - $expTotalSum,2) }}</td>
		    </tr>
  		</table>
  	</body>
</html>