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

    public static function isUser() {
        if (!Auth::isUser()) {
            return Response::notAuthorized();
        }
    }

    public static function isAdmin() {
        if (!Auth::isAdmin()) {
            return Response::notAuthorized();
        }
    }

    public static function isLoggedIn(){
        if (!Auth::isLoggedIn()){
            return Response::notAuthorized();
        }
    }

    public static function postMethod() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return Response::badRequest();
        }
    }

    public static function getMethod() {
        if ($_SERVER["REQUEST_METHOD"] !== "GET") {
            return Response::badRequest();
        }
    }
}
?>