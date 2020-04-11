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
@endsection

@section("scripts")
<script>
	const wsc = new WebSocket("ws://localhost:1500");

	wsc.addEventListener('open', function (event) {
		console.log("Connected")
	});

	// Listen for messages
	wsc.addEventListener('message', function (event) {
		let data = JSON.parse(event.data);

		alert("Message from server: '" + data.value + "'");
	});

	$(document).ready(function() {
		$("#ping-button").on("click", function() {
			wsc.send(JSON.stringify({
				"command": "ping",
			}));
		});

		$("#form-repeat").on("submit", function(event) {
			event.preventDefault();

			wsc.send(JSON.stringify({
				"command": "repeat",
				"toRepeat": $("#repeat-input").val(),
			}));
		})
	})
</script>
@endsection