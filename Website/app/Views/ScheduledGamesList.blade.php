<ul class="collection">
    @if(count($scheduledGames) > 0)
        @foreach ($scheduledGames as $scheduledGame)
            <li class="collection-item games">
                <b>{{ $scheduledGame["StartTime"] }}</b>
                <input type="text" value="{{$scheduledGame["ID"]}}" hidden>
            </li>
        @endforeach
    @else
        <li class="collection-item"><b>Er zijn geen geplande games</b></li>
    @endif
</ul>