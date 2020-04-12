@extends("Layouts.BaseLayout")

@section("title", "Join Tournament")

@section("constrained-content")
	<div class="row">
		<div class="col s3">
			<label for="scheduled-games">Ingeplande spellen</label>
			<div id="scheduled-games">

			</div>
			<button id="game-list-refresh" class="btn  modal-trigger waves-effect waves-light"
				style="width: 100%">Refresh
			</button>
		</div>

		<div id="game-info">

		</div>
	</div>
@endsection

@section("scripts")
	<script>
		let selectedTournamentID = null;

		$(document).ready(function () {
			document.addEventListener("userSignupChanged", selectGame)
			
			updateScheduledGames();
			$("#game-list-refresh").on("click", updateScheduledGames);
			$("#scheduled-games").on("click", "li", function(event) {
				selectedTournamentID = $(event.target).closest("li").data("id");
				selectGame();
			});

		});

		function updateScheduledGames() {
			$.ajax({
				method: "POST",
				url: "@asset('Tournament/ListScheduled')",
				dataType: "json",
			})
			.done(function(response) {
				if (response.success) {
					$("#scheduled-games").html(response.html);
				} else {
					serverError(response);
				}
			})
			.fail(serverError);
		}

		function selectGame(event) {
			if (selectedTournamentID === null) {
				$("#game-info").html("");
			};

			$.ajax({
				method: "POST",
				url: "@asset('Tournament/SelectGame')",
				dataType: "json",
				data: {
					"id": selectedTournamentID,
				}
			})
			.done(function(response) {
				if (response.success) {
					$("#game-info").html(response.html);
				} else {
					serverError(response);
				}
			})
			.fail(serverError);
		}
	</script>
@endsection
