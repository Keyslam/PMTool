<?php
class Middleware {
    public static function login() {
        if (Auth::isLoggedIn()) {
            return false;
        }
        return true;
    }

    public static function isUser() {
        return Auth::isUser();
    }

    public static function isAdmin() {
        return Auth::isAdmin();
    }

    public static function isLoggedIn(){
        return Auth::isLoggedIn();
    }

    public static function postMethod() {
        return $_SERVER["REQUEST_METHOD"] == "POST";
    }

    public static function getMethod() {
        return $_SERVER["REQUEST_METHOD"] == "GET";
    }
}
?>