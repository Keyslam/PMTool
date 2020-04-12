<?php

class HomeController
{
	public function indexAction()
	{
		//Middleware::login();

		return Response::view("Home");
	}

	public function loginAction()
	{
		//Middleware::login();

		$flash = Flash::get();

		return Response::view("Login", [
			"flash" => $flash,
		]);
	}

	public function loginPOSTAction()
	{
		if (!Middleware::postMethod()) { return Response::badRequest(); }
		//Middleware::login();

		$username = isset($_POST["username"]) ? trim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING)) : "";
		if ($username == "") {
			Response::badRequest();
		}
		try {
			$stmt = DB::Connection()->prepare("SELECT Password FROM User WHERE UserName = :username");
			$stmt->bindValue("username", $username);
			$stmt->execute();
			if ($stmt->rowCount() == 0) {
				Flash::put([
					"loginErrors" => ["Gebruikersnaam of Wachtwoord is incorrect"]
				]);
				Redirect::login();
			}
			$password = $stmt->fetchColumn();
			if (!password_verify(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING), $password)) {
				Flash::put([
					"loginErrors" => ["Gebruikersnaam of Wachtwoord is incorrect"]
				]);
				Redirect::login();
			}

			$stmt = DB::Connection()->prepare("SELECT ID, IsAdmin FROM User WHERE UserName=:username");
			$stmt->bindValue("username", $username);
			$stmt->execute();
			$result = $stmt->fetch();

			if ($result) {
				$_SESSION["user_id"] = $result["ID"];
				$_SESSION["user_is_admin"] = $result["IsAdmin"];

				if ($result["IsAdmin"]) {
					Redirect::adminHome();
				} else {
					Redirect::userHome();
				}
			} else {
				Flash::put([
					"loginErrors" => ["Ingevoerd gebruikernaam of wachtwoord is onjuist"],
				]);
				Redirect::login();
			}
		} catch (Exception $exception) {
			Response::internalServerError();
		}
	}

	public function registerAction()
	{
		Middleware::login();
		$flash = Flash::get();
		return Response::view("Register", [
			"flash" => $flash
		]);
	}

	public function registerPOSTAction()
	{
		Middleware::postMethod();
		Middleware::login();

		$username = isset($_POST["username"]) ? trim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING)) : "";;
		if ($username == "") {
			Response::badRequest();
		}

		$password = isset($_POST["password"]) ? password_hash(trim(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING)), PASSWORD_DEFAULT) : ""; // 0 = POST
		if ($password == "") {
			Response::badRequest();
		}

		$adminToken = isset($_POST['adminToken']) ? trim(filter_input(INPUT_POST, "adminToken", FILTER_SANITIZE_STRING)) : "";
		if ($adminToken != "") {
			try {
				$secret = parse_ini_file(configPath(), true)["admin"];
				if ($secret["token"] != $adminToken) {
					Flash::put([
						"registerErrors" => ["Admin Token Incorrect"]
					]);
					Redirect::register();
				}
			} catch (Exception $exception) {
				Response::internalServerError();
			}
		}

		if (password_verify(trim(filter_input(0, "rptPassword", FILTER_SANITIZE_STRING)), $password)) {
			try {
				$stmt = DB::Connection()->prepare("SELECT UserName FROM User WHERE UserName = :username");
				$stmt->bindValue("username", $username);
				$stmt->execute();
				if ($stmt->rowCount() == 0) {
					$stmt = DB::Connection()->prepare("INSERT INTO User(UserName, Password) Values(:username, :password)");
					$stmt->bindValue("username", $username);
					$stmt->bindValue("password", $password);
					$stmt->execute();
					if ($stmt->rowCount() == 1) {
						if ($adminToken != "") {
							$stmt = DB::Connection()->prepare("UPDATE User SET IsAdmin = 1 WHERE Username = :username");
							$stmt->bindValue("username", $username);
							$stmt->execute();
						}
						Redirect::login();
					} else {
						Flash::put([
							"registerErrors" => ["Account kon niet worden aangemaakt"]
						]);
						Redirect::register();
					}
				} else {
					Flash::put([
						"registerErrors" => ["Gebruikersnaam bestaat al!!"]
					]);
					Redirect::register();
				}
			} catch (Exception $exception) {
				echo $exception;
				Response::internalServerError();
			}
		} else {
			Flash::put([
				"registerErrors" => ["De wachtwoorden zijn niet het zelfde"]
			]);
			Redirect::register();
		}
	}

	public function activeGameAction() {
		return Response::view("ActiveGame");
	}
}
?>