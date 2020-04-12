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

        echo blade()->run("ViewParts.Todo"); // TODO
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