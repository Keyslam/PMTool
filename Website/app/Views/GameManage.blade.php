@extends("Layouts.BaseLayout")

@section("title", "Spellen beheren")

@section("constrained-content")
    <div class="row">
        <div class="col s3">
            <label for="scheduled-games">Ingeplande spellen</label>
            <ul id="scheduled-games">

            </ul>
            <button data-target="new-game-modal" class="btn  modal-trigger waves-effect waves-light"
                    style="width: 100%">Nieuw spel plannen
            </button>
        </div>

        <div class="col s3">
            <div class="row s3">
                <label for="start-date">Toernooi datum</label>
                <input id="start-date" type="text" class="datepicker">
                <label for="start-time">Start tijd</label>
                <input id="start-time" type="text" class="timepicker">
            </div>
            <div class="row s3">
                <label for="scheduled-games">Geregistreerde spelers</label>
                <ul id="player-list" class="collection">


                </ul>
            </div>


        </div>

        <div class="col s6">
            <form>
                <div class="row">
                    <div class="col s6">
                        <label for="chips">Chips</label>
                        <div id="chips" class="card" style="overflow: scroll; max-height: 700px">
                            <div class="card-content">
                                @for ($i = 0; $i < 10; $i++)
                                    <label for="chip-{{ $i }}">Chip {{ $i }}</label>
                                    <input id="chip-{{ $i }}" type="number" value="2,50">
                                @endfor
                            </div>
                        </div>

                    </div>

                    <div class="col s6">
                        <label for="blinds">Blinds</label>
                        <div id="blinds" class="card">
                            <div class="card-content">
                                <label for="big-blind">Big blind</label>
                                <input id="big-blind" type="number" value="2,50">

                                <label for="small-blind">Small blind</label>
                                <input id="small-blind" type="number" value="1,20">
                            </div>
                        </div>

                        <label for="price-pool">Pot</label>
                        <div id="price-pool" class="card">
                            <div class="card-content">
                                <label for="first-place">1ste plaats</label>
                                <input id="first-place" type="text" value="60%">

                                <label for="second-place">2de plaats</label>
                                <input id="second-place" type="text" value="30%">

                                <label for="third-place">3de plaats</label>
                                <input id="third-place" type="text" value="10%">
                            </div>
                        </div>

                        <label for="game-behaviour">Spel gedrag</label>
                        <div id="game-behaviour" class="card">
                            <div class="card-content">
                                <label for="round-time">Ronde tijd</label>
                                <input id="round-time" type="number" value="30">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s6 offset-s6">
                        <button class="btn waves-effect waves-light" style="width: 100%">Wijzigingen opslaan</button>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col s6">
                        <button class="btn waves-effect waves-light" style="width: 100%">Pauze forceren</button>
                    </div>

                    <div class="col s6">
                        <input type="checkbox"><span>Pauzeren wanneer ronde eindigt</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col s6">
                        <button class="btn waves-effect waves-light" style="width: 100%">Start forceren</button>
                    </div>

                    <div class="col s6">
                        <button id="remove-game" class="btn waves-effect waves-light" style="width: 100%">Spel
                            verwijderen
                        </button>
                    </div>
                </div>
            </form>
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
            $("#cancel-game").on("click", clearNewGameModal);
            $(".games").on("click", selectGameSettings);
            $("#remove-game").on("click", removeGame); // TODO: Add Tournament ID to button
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

        function removeGame(event) {
            event.preventDefault();
            $.ajax({
                method: "POST",
                url: "@asset('Tournament/AddNew')",
                dataType: "html",
                data: {
                    "id": $("").val(),
                }

            }).done(function (response) {
                if (response === "1") {
                    updateScheduledGames();
                } else {
                    alert('Toernooi niet verwijdert')
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

        function selectGameSettings() {
            $.ajax({
                method: "POST",
                url: "@asset('Tournament/SelectGameSettings')",
                dataType: "html",
                data: {
                    "id": $(this).lastChild.val()
                }
            }).done(function (data) {
                $("#player-list").html(data);

            }).fail(function () {
                alert('De toernooi data kon niet worden opgehaald');
            })
        }
    </script>
@endsection()