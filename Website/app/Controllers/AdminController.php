<?php
class AdminController {
	public function indexAction() {
		//Middleware::getMethod();
		if(!Auth::isAdmin()) { Redirect::login(); }

		return Response::view("Home");
	}
	
	public function manageGamesAction() {
		//Middleware::getMethod();
		if(!Auth::isAdmin()) { Redirect::login(); }

		return Response::view("GameManage", [
			//"scheduledGames" => $scheduled_games; 
		]); // TODO
	}

	public function statisticsAction() {
		//Middleware::getMethod();
		if(!Auth::isAdmin()) { Redirect::login(); }

		return Response::view("ViewParts.Todo"); // TODO
	}

	public function logoutGETAction() {
		//Middleware::getMethod();
		if(!Auth::isAdmin()) { Redirect::login(); }

		unset($_SESSION["user_id"]);
		unset($_SESSION["user_is_admin"]);

		Redirect::home();
	}
}
?>