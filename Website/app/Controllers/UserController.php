<?php
class UserController {
	public function indexAction() {
		if (!Middleware::getMethod()) { return Response::badRequest(); }
		if (!Auth::isUser()) { return Redirect::home(); }

		return Response::view("Home");
	}
	
	public function signupAction() {
		if (!Middleware::getMethod()) { return Response::badRequest(); }
		if (!Auth::isUser()) { return Redirect::home(); }

		return Response::view("GameSignup");
	}

	public function statisticsAction() {
		if (!Middleware::getMethod()) { return Response::badRequest(); }
		if (!Auth::isUser()) { return Redirect::home(); }

		try {
			$amountWon    = 0;
			$handsWon     = 0;
			$handsPlayed  = 0;
			
			$gamesPlayed  = 0;
			$gameWinrate  = 0;
			$handsWinrate = 0;
			
			{
				$stmt = DB::Connection()->prepare("SELECT AmountWon, HandsWon, HandsPlayed FROM GameStatistics WHERE UserID = :userID");
				$stmt->bindValue("userID", $_SESSION["user_id"]);
				$stmt->execute();
				$results = $stmt->fetchAll();		
			}	

			$stmt = DB::Connection()->prepare("SELECT COUNT('*') FROM GameStatistics INNER JOIN Tournament ON Tournament.ID=GameStatistics.TournamentID WHERE UserID = :userID AND Tournament.HasStarted");
			$stmt->bindValue("userID", $_SESSION["user_id"]);
			$stmt->execute();
			$gamesPlayed = $stmt->fetchColumn();

			foreach ($results as $result) {
				$amountWon += $result["AmountWon"];
				$handsWon += $result["HandsWon"];
				$handsPlayed += $result["HandsPlayed"];
			}

			if ($gamesPlayed != 0) {
				$gameWinrate = round($amountWon / $gamesPlayed * 100);
			}
			
			if ($handsPlayed != 0) {
				$handsWinrate = round($handsWon / $handsPlayed * 100);
			}

			return Response::view("UserStatistics", [
				"amountWon" => $amountWon,
				"gamesPlayed" => $gamesPlayed,
				"gamesWinrate" => $gameWinrate,
				"handsWon" => $handsWon,
				"handsPlayed" => $handsPlayed,
				"handsWinrate" => $handsWinrate,
			]);
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function logoutGETAction() {
		if (!Middleware::getMethod()) { return Response::badRequest(); }
		if (!Auth::isUser()) { return Redirect::home(); }

		unset($_SESSION["user_id"]);
		unset($_SESSION["user_is_admin"]);

		Redirect::home();
	}
}
?>