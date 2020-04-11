@extends("Layouts.BaseLayout")

@section("constrained-content")
    <div id="tables-container">

	</div>
@endsection

@section("scripts")
@include("Socket")
<script>
	$(document).ready(function() {
		$.ajax({
			method: "POST",
            url: "@asset('Tournament/ListTables')",
        	dataType: "html",
		})
		.done(function(data) {
			$("#tables-container").html(data);
		})
		
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

