<?php
namespace app\Controllers;

Use eftec\bladeone\BladeOne;

class HomeController {
	public function indexAction() {
		echo blade()->run("Home");
	}
}
?>