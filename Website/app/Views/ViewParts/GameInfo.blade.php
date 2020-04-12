<div class="col s6">
    <input id="tournament-id" type="text" value="{{$tournamentID}}" hidden>

    @if($isJoined == 0)
        <button class="btn waves-effect waves-light" id="join-game">Inschrijven</button>
    @else
        <button class="btn waves-effect waves-light" id="leave-game" invisible>Uitschrijven</button>
    @endif
</div>

<div class="col s3">
    <label for="player-list">Spelers</label>
    <ul id="player-list" class="collection">
        @if(count($playerList) > 0)
            @foreach($playerList as $player)
                <li class="collection-item">{{$player["UserName"]}}</li>
            @endforeach
        @else
            <li class="collection-item">Er zijn nog geen spelers</li>
        @endif
    </ul>

</div>

<script>
    var userSignupChangedEvent = new Event("userSignupChanged");

    $(document).ready(function () {
        $("#join-game").on("click", joinGame);
        $("#leave-game").on("click", leaveGame)
    })

    function joinGame() {
        $.ajax({
            method: "POST",
            url: "@asset('Tournament/JoinGame')",
            dataType: "json",
            data: {
                "TournamentID": $("#tournament-id").val(),
            }
        }).done(function (response) {
            if (response.success) {
                document.dispatchEvent(userSignupChangedEvent);
            } else {
                alert("Er is iets mis gegaan");
            }
        })
    }

    function leaveGame(){
        $.ajax({
            method: "POST",
            url: "@asset('Tournament/LeaveGame')",
            dataType: "html",
            data: {
                "TournamentID": $("#tournament-id").val(),
            }
        }).done(function (response) {
            document.dispatchEvent(userSignupChangedEvent);
        })
    }
</script>