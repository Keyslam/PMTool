@extends("Layouts.BaseLayout")

@section("title", "Home")

@section("constrained-content")
	<button id="ping-button" class="btn">
		Ping
	</button>

	<form id="form-repeat">
		<input id="repeat-input" type="text" required>
		<button class="btn" type="submit">Repeat</button>
	</form>

	<button id="join-button" class="btn">
		Join this game
	</button>
	<div id="joined-users"></div>
@endsection

@section("scripts")
<script>
	//
	// Websockets
	//

	const wsc = new WebSocket("ws://localhost:1500");

	let commands = {
		"newUserJoins": newUserJoins,
	}

	wsc.addEventListener('open', function (event) {
		console.log("Connected")
	});

	// Listen for messages
	wsc.addEventListener('message', function (event) {
		let data = JSON.parse(event.data);

		if (commands[data.command]) {
			console.log(data.command);
			commands[data.command](data);
		}
	});

	function newUserJoins(data) {
		updateJoinedUsers();
	}
	
	//
	// Document ready
	//

	$(document).ready(function() {
		$("#ping-button").on("click", function() {
			wsc.send(JSON.stringify({
				"command": "ping",
			}));
		});

		$("#join-button").on("click", function() {
			wsc.send(JSON.stringify({
				"command": "newUserJoins",
			}));
		});

		$("#form-repeat").on("submit", function(event) {
			event.preventDefault();

			wsc.send(JSON.stringify({
				"command": "repeat",
				"toRepeat": $("#repeat-input").val(),
			}));
		})

		updateJoinedUsers();
	})

	//
	//	DOM functions
	//

	function updateJoinedUsers() {
		$.ajax({
			method: "POST",
			url: "@asset('Test/JoinedUsers')", 
			dataType: "html",
		})
		.done(function (data) {
			$("#joined-users").html(data);
		})
		.fail(function () {
			alert("Something went wrong ;-;");
		});
	}
</script>
@endsection