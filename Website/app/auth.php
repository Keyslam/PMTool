<?php
class Auth {
    public function isLoggedIn() {
        return (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) ? true : false;
    }

    public function isAdmin() {
        return (isset($_SESSION["user_is_admin"]) && $_SESSION["user_is_admin"]);
    }
}
?>