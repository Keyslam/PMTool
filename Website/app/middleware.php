<?php
class Middleware {
    public static function login() {
        if (Auth::isLoggedIn()) {
            if (Auth::isAdmin()) {
                Redirect::adminHome();
            }
            else {
                Redirect::userHome();
            }
        }
    }

    public static function isAdmin() {
        if (!Auth::isAdmin()) {
            Redirect::notAuthorized();
        }
    }

    public static function isLoggedIn(){
        if (!Auth::isLoggedIn()){
            Redirect::notAuthorized();
        }
    }

    public static function postMethod() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            Redirect::badRequest();
        }
    }

    public static function getMethod() {
        if ($_SERVER["REQUEST_METHOD"] !== "GET") {
            Redirect::badRequest();
        }
    }
}
?>