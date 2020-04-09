<?php
class HomeController {
	public function indexAction() {
		echo blade()->run("Home");
	}

	public function loginAction() {
		Middleware::login();

		$flash = Flash::get();

		echo blade()->run("Login", [
			"flash" => $flash,
		]);
	}

	public function loginPOSTAction() {
		Middleware::postMethod();
		Middleware::login();

		$username = $_POST["username"]; // TODO: Sanitize and validate
		$password = $_POST["password"]; // TODO: Sanitize and validate

		$stmt = DB::Connection()->prepare("SELECT ID, IsAdmin FROM User WHERE UserName=:username AND Password=:password LIMIT 1");
		$stmt->bindValue("username", $username); 
		$stmt->bindValue("password", $password); 
		$stmt->execute();
		$result = $stmt->fetch();

		if ($result) {
			$_SESSION["user_id"]       = $result["ID"];
			$_SESSION["user_is_admin"] = $result["IsAdmin"];

			if ($result["IsAdmin"]) {
				Redirect::adminHome();
			}
			else {
				Redirect::userHome();
			}
		}
		else {
			Flash::put([
				"loginErrors" => ["Ingevoerd gebruikernaam of wachtwoord is onjuist"],
			]);
			Redirect::login();
		}
	}
}
?>