<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    <!-- Meta, title, CSS, favicons, etc. -->
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

	    <title>Somerset Homeowners Management System | </title>
	    <!-- Bootstrap -->
	    <link href="{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
	    <!-- Font Awesome -->
	    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
	    <!-- Animate.css -->
	    <link href="{{ URL::asset('css/animate.min.css')}}" rel="stylesheet">
	    <!-- Custom Theme Style -->
	    <link rel="stylesheet" href="{{ URL::asset('css/custom.css')}}" >
	</head>
	<body class="login">
		</style>
		<div>
			@yield('content')
		</div>		
		<!-- jQuery -->
	    <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js')}}"></script>
	    <!-- Bootstrap -->
	    <script src="{{ URL::asset('vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
	    <script type="text/javascript">
	    	$(document).ready(function(){
	    		$('a').click(function(){
	    			$('ul').toggle();
	    		});
	    	});
	    </script>
	</body>
</html>