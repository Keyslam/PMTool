<?php

class HomeController
{
    public function indexAction()
    {
        echo blade()->run("Home");
    }

    public function loginAction()
    {
        Middleware::login();

        $flash = Flash::get();

        echo blade()->run("Login", [
            "flash" => $flash,
        ]);
    }

    public function loginPOSTAction()
    {
        Middleware::postMethod();
        Middleware::login();

        $username = isset($_POST["username"]) ? trim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING)) : "";
        if ($username == "") {
            Redirect::badRequest();
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
            Redirect::internalServerError();
        }
    }

    public function registerAction()
    {
        $flash = Flash::get();
        echo blade()->run("Register", [
            "flash" => $flash
        ]);
    }

    public function registerPOSTAction()
    {
        Middleware::postMethod();

        $username = isset($_POST["username"]) ? trim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING)) : "";;
        if ($username == "") {
            Redirect::badRequest();
        }

        $password = isset($_POST["password"]) ? password_hash(trim(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING)), PASSWORD_DEFAULT) : ""; // 0 = POST
        if ($password == "") {
            Redirect::badRequest();
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
                Redirect::internalServerError();
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
                Redirect::internalServerError();
            }
        } else {
            Flash::put([
                "registerErrors" => ["De wachtwoorden zijn niet het zelfde"]
            ]);
            Redirect::register();
        }
    }
}

?>