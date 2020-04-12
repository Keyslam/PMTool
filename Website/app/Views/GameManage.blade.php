@extends("Layouts.BaseLayout")

@include("Socket")

@section("title", "Spellen beheren")

@section("constrained-content")
	<div class="row">
		<div class="col s3">
			<label for="scheduled-games">Ingeplande spellen</label>
			<div id="scheduled-games">

			</div>
			
			<button data-target="new-game-modal" class="btn  modal-trigger waves-effect waves-light"
				style="width: 100%">Nieuw spel plannen
			</button>
		</div>

		<div id="game-settings" class="col s9">

		</div>
	</div>

	<div id="new-game-modal" style="min-height: 450px;" class="modal">
		<form id="new-game-form">
			<div class="modal-content">
				<h5 class="center">Kies een datum en tijdstip voor een nieuwe game</h5>

				<br>

				<div class="row">
					<div class="col s10 offset-s1">
						<label for="date">Kies een datum:</label>
						<input id="date" type="text" class="datepicker" required>
					</div>

					<div class="col s10 offset-s1">
						<label for="time">Kies een tijd:</label>
						<input id="time" type="time" class="timepicker" required>
					</div>

					<div class="col s4 offset-s4" style="bottom: 30px; position: absolute;">
						<button style="width: 40%; float: left;" type="submit" id="new-game" class="btn waves-effect waves-light">Opslaan</button>
						<button style="width: 40%; float: right;" id="cancel-game" class="btn waves-effect waves-light modal-close">Annuleren</button>
					</div>
				</div>
			</div>

			
		</form>
	</div>
@endsection

@section("scripts")
	<script>
	var id = null;
		$(document).ready(function () {
			document.addEventListener("gameRemoved", updateScheduledGames);
			document.addEventListener("userSignupChanged", updateGamesettings);

			socketCommands["newGameAdded"] = function() {
				updateScheduledGames();
			}

			updateScheduledGames();
			$("#new-game-form").on("submit", newGame);
			$("#cancel-game").on("click", clearNewGameModal)
			$("#scheduled-games").on("click", "li", selectGame);
		});

		function clearNewGameModal() {
			$("#date").val("");
			$("#time").val("");
		}

		function newGame(event) {
			event.preventDefault();
			$.ajax({
				method: "POST",
				url: "@asset('Tournament/AddNew')",
				dataType: "json",
				data: {
					"time": $("#time").val(),
					"date": $("#date").val()
				}
			}
			).done(function (response) {
				if (response.success) 
				{
					$("#new-game-modal").modal("close");
					clearNewGameModal();

					wsc.send(JSON.stringify({
						"command": "newGameAdded", 
						"gameID": response,
					}));
				} else {
					serverError(response);
				}
			})
			.fail(serverError);
		}

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
			id =  $(event.target).closest("li").data("id");
			updateGamesettings();
		}

		function updateGamesettings() {
			$.ajax({
				method: "POST",
				url: "@asset('Tournament/SelectGameSettings')",
				dataType: "json",
				data: {
					"id": id
				}
			}).done(function(response) {
				if (response.success) {
					$("#game-settings").html(response.html);
				} else {
					serverError(response);
				}
			}).fail(serverError)
		}
	</script>
@endsection()