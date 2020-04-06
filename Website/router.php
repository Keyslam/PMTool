<?php
session_start();

include 'app/app.php';

// Do routing
if (router()->getType() == 'controller') {
	try {
		router()->callObject('App\Controllers\%sController', true);
	} catch (Exception $e) {
		echo $e;
		echo blade()->run('404');
	}
}
?>