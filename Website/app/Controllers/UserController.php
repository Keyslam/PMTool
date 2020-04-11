<?php
class UserController {
	public function indexAction() {
	    Middleware::getMethod();
		echo blade()->run("Home");
    }
    
    public function signupAction() {
	    Middleware::getMethod();
        Middleware::login();

        echo blade()->run("GameSignup");
    }

    public function statisticsAction() {
	    Middleware::getMethod();

        echo blade()->run("ViewParts.Todo"); // TODO
    }

    public function logoutGETAction() {
	    Middleware::getMethod();

        unset($_SESSION["user_id"]);
        unset($_SESSION["user_is_admin"]);

        Redirect::home();
    }
}
?>