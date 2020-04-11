<?php
class Redirect {
	public static function badRequest() {
		http_response_code(400);
		header("Location: ".path()."Error/BadRequest/");
		die();
	}
    
	public static function notAuthorized() {
		http_response_code(401);
		header("Location: ".path()."Error/NotAuthorized/");
		die();
	}

	public static function  NotFound() {
	    http_response_code(404);
	    header("Location: ".path()."Error/NotFound/");
	    die();
	}
	
	public static function  Locked() {
	    http_response_code(423);
	    header("Location: ".path()."Error/Locked/");
	    die();
    }

	public static function internalServerError(){
	    http_response_code(500);
	    header("Location: ".path()."Error/InternalServerError/");
	    die( );
    }
    
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