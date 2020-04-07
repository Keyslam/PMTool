<?php
class Redirect {
	public static function badRequest() {
		http_response_code(400);
		header("Location: ".path()."Error/");
		die();
	}
    
	public static function notAuthorized() {
		http_response_code(401);
		header("Location: ".path()."Error/");
		die();
	}
    
  	public static function home() {
		header("Location: ".path());
		die();
	}

	public static function login() {
		header("Location: ".path()."Home/Login/");
		die();
	}

	public static function adminHome() {
		header("Location: ".path()."Admin/");
		die();
	}

	public static function userHome() {
		header("Location: ".path()."User/");
		die();
	}
}
?>