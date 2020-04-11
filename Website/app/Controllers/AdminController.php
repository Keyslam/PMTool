<?php
class AdminController {
	public function indexAction() {
        Middleware::isAdmin();

		echo blade()->run("Home");
    }
    
    public function manageGamesAction() {
	    Middleware::isAdmin();

        echo blade()->run("GameManage", [
            //"scheduledGames" => $scheduled_games; 
        ]); // TODO
    }

    public function statisticsAction() {
        Middleware::isAdmin();

        echo blade()->run("Todo"); // TODO
    }

    public function logoutPOSTAction() {
	    Middleware::getMethod();
        Middleware::isAdmin();

	    unset($_SESSION["user_id"]);
        unset($_SESSION["user_is_admin"]);

        Redirect::home();
    }
}
?>