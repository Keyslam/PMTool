<?
if (isset($_SESSION["user_type"])) {  
    header("Location: index.php");
    die();
}
?>


<form action="private/src/authenticate.php" method="POST">
    <div class="input-field">
        <input id="username" name="username" type="text" required>
        <label for="username">Username</label>
    </div>

    <div class="input-field">
        <input id="password" name="password" type="password" required>
        <label for="password">Password</label>
    </div>

    <label>
        <input type="checkbox" class="filled-in"/>
        <span>Remember me?</span>
    </label>

    <input style="float:right;" class="btn" type="submit" value="Log in">
</form>