<ul class="collection">
@foreach ($scheduledGames as $scheduledGame)
	<li class="collection-item"><b>Test Spel {{ $scheduledGame["ID"] }}</b><br>{{ $scheduledGame["StartTime"] }}</li>
@endforeach
</ul>