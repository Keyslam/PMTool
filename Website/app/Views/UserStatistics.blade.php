@extends("Layouts.BaseLayout")

@section("title", "UserStatistics")

@section("constrained-content")
	<label for="games-statistics">Spellen</label>
	<ul id="games-statistics" class="collection">
		<li class="collection-item">Gespeeld: {{ $gamesPlayed}}</li>
		<li class="collection-item">Gewonnen: {{ $amountWon}}</li>
		<li class="collection-item">Winratio: {{ $gamesWinrate }}</li>
	</ul>

	<label for="hands-statistics">Handen</label>
	<ul id="hands-statistics" class="collection">
		<li class="collection-item">Gewonnen: {{ $handsWon}}<li>
		<li class="collection-item">Gespeeld: {{ $handsPlayed}}</li>
		<li class="collection-item">Winratio: {{$handsWinrate}}%</li>
	</ul>
@endsection