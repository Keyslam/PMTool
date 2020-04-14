<input id="tournament-id" type="text" value="{{$tournamentID}}" readonly hidden>
<div class="col s4">
    <div class="row">
        <label for="start-date">Toernooi datum</label>
        <input id="start-date" type="text" value="{{$settings["time_part"]}}" class="datepicker">
        <label for="start-time">Start tijd</label>
        <input id="start-time" type="text" value="{{$settings["date_part"]}}" class="timepicker">
    </div>

    <div class="row">
        <label for="scheduled-games">Geregistreerde spelers</label>
        <ul id="player-list" class="collection">
            @if($playerList > 0)
                @foreach($playerList as $player)
                    <li class="collection-item">{{$player["UserName"]}}<input type="text" value="{{$player["ID"]}}"
                                                                              hidden>
                        <i class="material-icons small remove-player right" data-id = {{$player["ID"]}} class="remove-player">close</i>
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

<script>
    var gameRemovedEvent = new Event("gameRemoved");
    var userSignupChangedEvent = new Event("userSignupChanged");
    
    $(document).ready(function () {
        $("#remove-game").on("click", removeGame);
        $(".remove-player").on("click", removePlayer);
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
        .done(serverSuccess(function(response) {
            document.dispatchEvent(gameRemovedEvent);
        }))
        .fail(serverError);
    }

    function removePlayer(event){
        var id = $(event.target).closest("i").data("id");
        $.ajax({
            method: "POST",
            url: "@asset('Tournament/RemoveFromGame')",
            dataType: "json",
            data: {
                "TournamentID": $("#tournament-id").val(),
                "id" : $(event.target).closest("i").data("id")
            }
        })
        .done(function(response) {
            if (response.success) {
                document.dispatchEvent(userSignupChangedEvent);
            } else {
                serverError(response);
            }
        })
        .fail(serverError);
    }
</script>