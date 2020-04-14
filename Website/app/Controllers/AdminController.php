<?php
class AdminController {
	public function indexAction() {
		if (!Middleware::getMethod()) { return Response::badRequest(); }
		if (!Middleware::isAdmin()) { return Redirect::login(); }

		return Response::view("Home");
	}
	
	public function manageGamesAction() {
		if (!Middleware::getMethod()) { return Response::badRequest(); }
		if (!Auth::isAdmin()) { Redirect::login(); }

		return Response::view("GameManage", [
			//"scheduledGames" => $scheduled_games; 
		]); // TODO
	}

	public function statisticsAction() {
		if (!Middleware::getMethod()) { return Response::badRequest(); }
		if (!Auth::isAdmin()) { Redirect::login(); }

		return Response::view("ViewParts.Todo"); // TODO
	}

	public function logoutGETAction() {
		if (!Middleware::getMethod()) { return Response::badRequest(); }
		if (!Auth::isAdmin()) { Redirect::login(); }

		unset($_SESSION["user_id"]);
		unset($_SESSION["user_is_admin"]);

		Redirect::home();
	}
}
?>