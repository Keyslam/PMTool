<script>
    const wsc = new WebSocket("ws://localhost:1500");

	wsc.addEventListener('open', function (event) {
		console.log("Connected to server")
	});

	wsc.addEventListener('message', function (event) {
		let data = JSON.parse(event.data);

		alert("Message from server: '" + data.value + "'");
	})
</script>