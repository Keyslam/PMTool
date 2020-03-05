<?
session_start();

if (isset($_SESSION["user_type"])) {
    $user_type = $_SESSION["user_type"];

    if ($user_type === "admin") {
        include("nav-bar-admin.php");
    }
    elseif ($user_type === "player") {
        include("nav-bar-user.php");
    }
}
else {
    include("nav-bar-default.php");
}
?>