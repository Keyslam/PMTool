<?php
class UserController {
	public function indexAction() {
		Middleware::getMethod();
		Middleware::IsUser();

		echo blade()->run("Home");
	}
	
	public function signupAction() {
		Middleware::getMethod();
		Middleware::IsUser();

		echo blade()->run("GameSignup");
	}

	public function statisticsAction() {
		Middleware::getMethod();
		Middleware::IsUser();

		try {
			$stmt = DB::Connection()->prepare("SELECT AmountWon, HandsWon, HandsPlayed FROM GameStatistics WHERE UserID = :UserID");
			$stmt->bindValue("UserID", $_SESSION["user_id"]);
			if ($stmt->execute()) {
				$results = $stmt->fetch();
				
				$averageHandsWon = 0;
				if ($results["HandsPlayed"] > 0) {
					$averageHandsWon = round($results["HandsWon"]/$results["HandsPlayed"] * 100);
				}

				echo blade()->run("UserStatistics", [
					"amountWon" => $results["AmountWon"],
					"handsWon" => $results["HandsWon"],
					"handsPlayed" => $results["HandsPlayed"],
					"averageHandsWon" => $averageHandsWon,
				]);
			} else {
				Redirect::internalServerError();
			}
		} catch (Exception $exception) {
			Redirect::internalServerError();
		}
	}

	public function logoutGETAction() {
		Middleware::getMethod();
		Middleware::IsUser();

		unset($_SESSION["user_id"]);
		unset($_SESSION["user_is_admin"]);

		Redirect::home();
	}
}
?>