@extends("Layouts.BaseLayout")

@section("title", "Spellen beheren")

@section("constrained-content")
    <div class="row">
        <div class="col s3">
            <label for="scheduled-games">Ingeplande spellen</label>
            <ul id="scheduled-games" class="collection">

            </ul>
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
                <h4>Kies een datum en tijdstip voor een nieuwe game</h4>
                <label for="date">Kies een datum:</label>
                <input id="date" type="text" class="datepicker" required>
                <label for="time">Kies een tijd:</label>
                <input id="time" type="text" class="timepicker" required>
            </div>
            <div class="modal-footer">
                <button id="cancel-game" class="btn waves-effect waves-light modal-close">Annuleren</button>
                <button type="submit" id="new-game" class="btn waves-effect waves-light">Opslaan</button>
            </div>
        </form>
    </div>
@endsection

@section("scripts")
    <script>
        $(document).ready(function () {
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
                dataType: "html",
                data: {
                    "time": $("#time").val(),
                    "date": $("#date").val()
                }

            }).done(function (response) {
                if (response === "1") {
                    $("#new-game-modal").modal("close");
                    updateScheduledGames();
                    clearNewGameModal();
                } else {
                    alert('Toernooi niet aangemaakt')
                }
            });
        }



        function updateScheduledGames() {
            $.ajax({
                method: "POST",
                url: "@asset('Tournament/ListScheduled')",
                dataType: "html",
            })
                .done(function (data) {
                    $("#scheduled-games").html(data);
                })
                .fail(function () {
                    alert("Something went wrong ;-;");
                });
        }

        function selectGame(event) {
            $.ajax({
                method: "POST",
                url: "@asset('Tournament/SelectGameSettings')",
                dataType: "html",
                data: {
                    "id": $(event.target).closest("li").data("id")
                }
            }).done(function (data) {
                $("#game-settings").html(data);
            }).fail(function () {
                alert('De toernooi data kon niet worden opgehaald');
            })
        }
    </script>
@endsection()