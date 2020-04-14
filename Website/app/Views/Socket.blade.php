<script>
    const wsc = new WebSocket("ws://localhost:1500");

	let socketCommands = {};

	wsc.addEventListener('open', function (event) {
		console.log("Connected to server")
	});

	wsc.addEventListener('message', function (event) {
		let data = JSON.parse(event.data);

		if (socketCommands[data.command]) {
			console.log(data.command + " : " + data);
			socketCommands[data.command](data);
		}
	});
</script>