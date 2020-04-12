<?php
class Redirect {
  	public static function home() {
		header("Location: ".path());
		die();
	}

	public static function login() {
		header("Location: ".path()."Home/Login/");
		die();
	}

	public static function register() {
	    header("Location: ".path()."Home/Register/");
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