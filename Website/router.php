<?php
session_start();

include 'app/app.php';

try {
	$response = json_decode(router()->callObject("%sController"), true);

	if ($response["response_code"] === 200) {
		echo $response["html"];
	} else {
		echo blade()->run("Errors.".$response["response_code"]);
	}
} catch(Exception $e) {
	try {
		echo blade()->run("Errors.404");
	} catch(Exception $e)  {
		echo "Iets is HEEL ERG mis gegaan!";
	}
}

