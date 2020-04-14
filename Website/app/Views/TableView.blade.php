@extends("Layouts.BaseLayout")

@section("title", "Tafel")

@section("constrained-content")

<div class="row">
	<h3 class="col m12 s12 l12 center" id="status">Wacht tot de ronde begint...</h3>
	<h4 class="col m12 s12 l12 center" id="time"></h4>


	<br>
	<br>

	<div class="col s12 l3" id="fiches">
	</div>

	<div class="col s12 l3" id="blinds">
	</div>
	
	<div class="col s12 l6" id="playerslist">
	</div>
</div>

@endsection
@section('scripts')

@include("Socket")
<script>
$(document).ready(function() {
	socketCommands["settingsChanged"] = function() {
		refreshFiches();
		refreshBlinds();
	}
	socketCommands["roundStart"] = function(data) {
		$("#status").html("Ronde is begonnen!");
	}
	socketCommands["gameEnd"] = function() {
		$("#status").html("Spel is beëindigd!");
	}
	socketCommands["roundPause"] = function() {
		$("#status").html("Ronde is gepauzeerd...");
	}
	socketCommands["roundEnd"] = function() {
		$("#status").html("Ronde is beëindigd. Wacht tot de volgende ronde...");
	}

	socketCommands["userChanged"] = refreshPlayers;

	socketCommands["userSignup"]  = refreshPlayers;
	socketCommands["userSignout"] = refreshPlayers;

	refreshFiches();
	refreshBlinds();
	refreshPlayers();
})

function refreshFiches() {
	$.ajax({
		method: "POST",
		url: "@asset('Table/getFiches')",
		dataType: "json",
	})
	.done(serverSuccess(function(response) {
		$('#fiches').html(response.html)
	}))
	.fail(serverError);
}

function refreshBlinds() {
	$.ajax({
		method: "POST",
		url: "@asset('Table/getBlinds')",
		dataType: "json",
	})
	.done(serverSuccess(function(response) {
		$('#blinds').html(response.html)
	}))
	.fail(serverError);
}

function refreshPlayers() {
	$.ajax({
		method: "POST",
		url: "@asset('Table/getPlayers')",
		dataType: "json",
	})
	.done(serverSuccess(function(response) {
		$('#playerslist').html(response.html)
	}))
	.fail(function(response) {
		alert("aaa");
	});
}
</script>

@endsection