<?
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    return false;
}

$username = $_POST["username"];
$password = $_POST["password"];

if (!isset($username)) {
    return false;
}

if (!isset($password)) {
    return false;
}

if ($username === "Admin" && $password === "Admin") {
    session_start();

    $_SESSION["user_type"] = "admin";

    header("Location: ../../dashboard-admin.php");
}
else {
    session_start();

    $_SESSION["user_type"] = "player";
        
    header("Location: ../../dashboard-user.php");
}
?>