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
}
?>