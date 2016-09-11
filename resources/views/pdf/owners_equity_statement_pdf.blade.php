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
		     <p><strong> Somerset Homeowners Association</strong></p>
              <p><strong>B18 L22 Barrington, Somerset Ave, Pasig, Metro Manila</strong></p>
              <p><strong>(02) 470 0040</strong></p>
              <p><strong>somersetplace@gmail.com</strong></p>
		     <p><strong>Statement of Changes in Equity </strong></p>
		     <p>For
		     	@if(empty($monthFilter))
		     		Year End {{$yearFilter}}
		     	@else
		     		Month End {{$monthArray[$monthFilter]}},{{$yearFilter}}
		     	@endif
		     </p>
		</div>
		<hr/>
		<table style="width:100%; border-collapse: collapse;">
		    <!-- equity items -->
		    @foreach($equityItemsList as $key => $value)
			    <tr>
			        <td width="30%"> {{$key}}</td>
			        @if($value>0)
			        	<td  align="right" width="35%">PHP {{number_format($value,2)}}</td>
			        	<td  width="35%"></td>
			        @else
			        	<td  width="35%"></td>
			        	<td align="right" width="35%">PHP {{number_format(($value*-1),2)}}</td>
			        @endif
			        
			    </tr>
		    @endforeach
		    <tr>
  				<td>
  					Profits for the period
  				</td>
				@if($totalProfit>0)
					<td  align="right" width="35%">PHP {{number_format($totalProfit,2)}}</td>
	        		<td  width="35%"></td>
				@else
					<td  width="35%"></td>
	        		<td align="right" width="35%">PHP {{number_format(($totalProfit*-1),2)}}</td>
				@endif
  			</tr>
		      
		    <tr>
		        <td colspan="2"> <strong>Balance at the end of the Period: </strong></td>
		        <td align="right" width="35%">PHP {{ number_format($eqTotalSum,2) }}</td>
		    </tr>
  		</table>
  	</body>
</html>