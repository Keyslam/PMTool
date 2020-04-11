<div class="col s6">
    <input id="tournament-id" type="text" value="{{$tournamentID}}" hidden>
    @if($isJoined == 0)
        <button id="join-game">Inschrijven</button>
    @else
        <butten id="leave-game">Uitschrijven</butten>
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
    $(document).ready(function () {
        $("#join-game").on("click", joinGame);
        $("#leave-game").on("click", leaveGame)
    })

    function joinGame() {
        $.ajax({
            method: "POST",
            url: "@asset('Tournament/JoinGame')",
            dataType: "html",
            data: {
                "TournamentID": $("#tournament-id").val(),
            }
        }).done(function (response) {
            if (response === "1") {
                alert(response);
            } else {
                alert(response);
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
            if (response === "1") {

            } else {
                alert("U bent niet uitgeschreven voor dit toernooi");
            }
        })
    }
</script>