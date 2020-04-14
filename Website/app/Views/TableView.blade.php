@extends("Layouts.BaseLayout")

@section("title", "Tafel")

@section("constrained-content")

<div class="row">
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