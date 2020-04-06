<?php
class HomeController {
	public function indexAction() {
		echo blade()->run("Home");
	}

	public function loginAction() {
		echo blade()->run("Login");
	}

	public function loginPOSTAction() {
		//TODO
	}
}
?>