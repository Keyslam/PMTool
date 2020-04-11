<?php
class UserController {
	public function indexAction() {
		echo blade()->run("Home");
    }
    
    public function signupAction() {
        Middleware::login();

        echo blade()->run("Todo"); // TODO
    }

    public function statisticsAction() {

        echo blade()->run("Todo"); // TODO
    }

    public function logoutPOSTAction() {
	    Middleware::getMethod();
        Middleware::login();

        unset($_SESSION["user_id"]);
        unset($_SESSION["user_is_admin"]);

        Redirect::home();
    }
}
?>