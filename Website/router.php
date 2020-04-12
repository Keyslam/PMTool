<?php
session_start();

include "app/app.php";

if (!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
	try {
		echo router()->callObject("%sController", false);
		die();
	} catch (Exception $e) {
		echo blade()->run("Errors.500");
		die();
	}
}

try {
	$response = json_decode(router()->callObject("%sController", false), true);

	if ($response === null) {
		throw new Exception();
	}

	if ($response["response_code"] === 200) {
		echo $response["html"];
	} else {
		echo blade()->run("Errors.".$response["response_code"], [
			"exception" => $response["exception"],
		]);
	}
} catch(Exception $e) {
	try {
		echo blade()->run("Errors.404");
	} catch(Exception $e)  {
		echo "Iets is HEEL ERG mis gegaan!";
	}
}

