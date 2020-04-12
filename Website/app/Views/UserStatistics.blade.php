@extends("Layouts.BaseLayout")

@section("title", "UserStatistics")

@section("constrained-content")
	<h1>Gewonnen games: {{ $amountWon}}</h1>
	<h1>Handen gewonnen: {{ $handsWon}}<h1>
	<h1>Handen gespeeld: {{ $handsPlayed}}</h1>
	<h1>Gemiddelde gewonnen handen: {{$averageHandsWon}}%</h1>
@endsection