<?php
class TournamentController {
	public function ListScheduledAction() {
		Middleware::postMethod();
		Middleware::isAdmin();

		$stmt = DB::Connection()->prepare("SELECT * FROM Tournament WHERE HasStarted='false' AND HasEnded='false' ORDER BY StartTime ASC");
		$success = $stmt->execute();
		
		if ($success) {
			$results = $stmt->fetchAll();
		
			echo blade()->run("ScheduledGamesList", [
				"scheduledGames" => $results,
			]);
		}
	}
}
?>