<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta charset="UTF-8">

   		<title>PMTool - @yield('title')</title>

      	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" >
		<link rel="stylesheet" href="@asset('css/materialize.css')" media="screen, projection">
	</head>
	
	<body>
		@include("Navbar")

		@yield('content')

		<div class="container">
			

   			@yield('constrained-content')
		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		
		@yield('scripts')
	</body>
</html>