// TODO
<label for="playerlist">Spelers</label>
        <ul class="collection" id="playerlist">
            @foreach ($players as $player)
            <li class="collection-item"> {{ $player["UserName"] }} </li>
            @endforeach
        </ul>