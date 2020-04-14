@extends("Layouts.BaseLayout")

@section("title", "Join Tournament")

@section("constrained-content")
	<div class="row">
		<div class="col l3">
			<label for="scheduled-games">Ingeplande spellen</label>
			<div id="scheduled-games">
			</div>
		</div>

		<div class="col l">
			<div id="game-info">

			</div>
		</div> 
	</div>
@endsection

@include("socket")
@section("scripts")
	<script>
		let selectedTournamentID = null;

		$(document).ready(function () {
			socketCommands["gameAdded"] = updateScheduledGames;
			socketCommands["gameRemoved"] = updateScheduledGames;

			socketCommands["userSignup"] = selectGame;
			socketCommands["userSignout"] = selectGame;
			
			updateScheduledGames();

			$("#scheduled-games").on("click", "li", function(event) {
				selectedTournamentID = $(event.target).closest("li").data("id");
				selectGameView($(event.target).closest("li"));
				selectGame();
			});
		});

		function updateScheduledGames() {
			$.ajax({
				method: "POST",
				url: "@asset('Tournament/ListScheduled')",
				dataType: "json",
			})
			.done(serverSuccess(function(response) {
				$("#scheduled-games").html(response.html);
			}))
			.fail(serverError);
		}

		function selectGame(event) {
			if (selectedTournamentID === null) {
				$("#game-info").html("");
				return;
			};

			$.ajax({
				method: "POST",
				url: "@asset('Tournament/SelectGame')",
				dataType: "json",
				data: {
					"id": selectedTournamentID,
				}
			})
			.done(serverSuccess(function(response) {
				$("#game-info").html(response.html);
			}))
			.fail(serverError);
		}
	</script>
@endsection
