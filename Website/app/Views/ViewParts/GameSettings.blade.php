<input id="tournament-id" type="text" value="{{$tournamentID}}" readonly hidden>
<div class="col s4">
    <div class="row">
        <label for="start-date">Toernooi datum</label>
        <input id="start-date" type="text" value="{{$dateTime["StartTime"]}}" class="datepicker">
        <label for="start-time">Start tijd</label>
        <input id="start-time" type="text" value="{{$dateTime["StartDate"]}}" class="timepicker">
    </div>

    <div class="row">
        <label for="scheduled-games">Geregistreerde spelers</label>
        <ul id="player-list" class="collection">
            @if($playerList > 0)
                @foreach($playerList as $player)
                    <li class="collection-item">{{$player["UserName"]}}<input type="text" value="{{$player["ID"]}}"
                                                                              hidden>
                        <i class="material-icons small remove-player right" data-id={{$player["ID"]}} style="cursor:
                           pointer;">close</i>
                    </li>
                @endforeach
            @else()
                <li class="collection-item">Er hebben zijn nog geen spelers aan gemeld voor dit toernooi</li>
            @endif
        </ul>
    </div>


</div>

<div class="col s8">
    <form>
        <div class="row">
            <div class="col s6">
                <label for="chips">Chips</label>
                <div id="chips" class="card" style="overflow: scroll; max-height: 700px">
                    <div class="card-content">
                        @foreach ($settings["chipsList"] as $chip=>$value)
                            <label for="chip-{{ $chip }}">{{$chip}}</label>
                            <input id="chip-{{ $chip}}" type="number" value="{{$value}}">
                        @endforeach
                    </div>
                </div>

            </div>

            <div class="col s6">
                <label for="blinds">Blinds</label>
                <div id="blinds" class="card">
                    <div class="card-content">
                        <label for="big-blind">Big blind</label>
                        <input id="big-blind" type="number" value="{{$settings["bigBlind"]}}">

                        <label for="small-blind">Small blind</label>
                        <input id="small-blind" type="number" value="{{$settings["bigBlind"]/2}}">
                    </div>
                </div>

                <label for="price-pool">Pot</label>
                <div id="price-pool" class="card">
                    <div class="card-content">
                        @foreach($settings["potDivision"] as $place=>$amount)
                            <label for="{{$place."-Plaats"}}">{{$place. " Plaats"}}</label>
                            <input id="{{$place."-Plaats"}}" type="text" value="{{$amount}}">
                        @endforeach

                    </div>
                </div>

                <label for="game-behaviour">Spel gedrag</label>
                <div id="game-behaviour" class="card">
                    <div class="card-content">
                        <label for="round-time">Ronde tijd</label>
                        <input id="round-time" type="number" value="{{$settings["roundTime"]}}">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s6 offset-s6">
                <button id="save-settings" class="btn waves-effect waves-light" style="width: 100%">Wijzigingen
                    opslaan
                </button>
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

<script>
    $(document).ready(function () {
        $("#remove-game").on("click", removeGame);
        $(".remove-player").on("click", removePlayer);
        $("#save-settings").on("click", saveSettings)
    })

    function removeGame(event) {
        event.preventDefault();
        $.ajax({
            method: "POST",
            url: "@asset('Tournament/RemoveGame')",
            dataType: "json",
            data: {
                "id": $("#tournament-id").val()
            }
        })
            .done(serverSuccess(function (response) {
                wsc.send(JSON.stringify({
                    "command": "gameRemoved",
                }));
            }))
            .fail(serverError);
    }

    function removePlayer(event) {
        var tournamentID = $("#tournament-id").val();
        var userID = $(event.target).closest("i").data("id")

        $.ajax({
            method: "POST",
            url: "@asset('Tournament/RemoveFromGame')",
            dataType: "json",
            data: {
                "TournamentID": tournamentID,
                "id": userID,
            }
        })
            .done(serverSuccess(function (response) {
                wsc.send(JSON.stringify({
                    "command": "userSignout",
                }));
            }))
            .fail(serverError);
    }

    function saveSettings() {
        $.ajax({
            method: "POST",
            url: "@asset('Tournament/UpdateSettings')",
            dataType: "json",
            data: {
                "ID": $("#tournament-id").val(),
                "startTime": $("#start-time").val(),
                "startDate": $("#startDate").val(),
                "settings": {
                    "bigBlind": $("#big-blind").val(),
                    "chipsList": {
                        "Wit": $("#Wit").val(),
                        "Rood": $("#Rood").val(),
                        "Blauw": $("#Blauw").val(),
                        "Zwart": $("#Zwart").val(),
                        "Groen": $("#Groen").val()
                    },
                    "roundTime": $("#round-time").val(),
                    "potDivision": {
                        "1ste Plaats": $("#1ste-Plaats").val(),
                        "2de Plaats": $("#2de-Plaats").val(),
                        "3de Plaats": $("#3de-Plaats").val(),
                    }
                }
            }
        })
            .done(serverSuccess(function (response) {
                wsc.send(JSON.stringify({
                    "command": "settingsChanged",
                }));
            }))
            .fail(serverError);
    }
</script>