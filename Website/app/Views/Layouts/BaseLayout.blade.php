<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta charset="UTF-8">

   	<title>PMTool - @yield('title')</title>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" >
		<link rel="stylesheet" href="@asset('css/materialize.css')" media="screen, projection">
	</head>
	
	<body>
		@include("Navbar")
		

		@yield('content')

		<div class="container">
			@include("Header")

   			@yield('constrained-content')
		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		
		<script>
			$(document).ready(function() {
				M.AutoInit();
			});
		</script>	

		@yield('scripts')
	</body>
</html>