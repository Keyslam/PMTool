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
			$stmt = DB::Connection()->prepare("SELECT AmountWon, HandsWon, HandsPlayed FROM GameStatistics WHERE UserID = :UserID");
			$stmt->bindValue("UserID", $_SESSION["user_id"]);
			$stmt->execute();
			$results = $stmt->fetch();
				
			$averageHandsWon = 0;
			if ($results["HandsPlayed"] > 0) {
				$averageHandsWon = round($results["HandsWon"]/$results["HandsPlayed"] * 100);
			}

			return Response::view("UserStatistics", [
				"amountWon" => $results["AmountWon"],
				"handsWon" => $results["HandsWon"],
				"handsPlayed" => $results["HandsPlayed"],
				"averageHandsWon" => $averageHandsWon,
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