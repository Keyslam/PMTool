<?php
class AdminController {
	public function indexAction() {
		Middleware::getMethod();
		Middleware::isAdmin();

		echo blade()->run("Home");
	}
	
	public function manageGamesAction() {
		Middleware::getMethod();
		Middleware::isAdmin();

		echo blade()->run("GameManage", [
			//"scheduledGames" => $scheduled_games; 
		]); // TODO
	}

	public function statisticsAction() {
		Middleware::getMethod();
		Middleware::isAdmin();

		echo blade()->run("ViewParts.Todo"); // TODO
	}

	public function logoutGETAction() {
		Middleware::getMethod();
		Middleware::isAdmin();

		unset($_SESSION["user_id"]);
		unset($_SESSION["user_is_admin"]);

		Redirect::home();
	}
}
?>