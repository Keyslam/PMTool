<?php
class TableController {
	public function indexAction() {
		return Response::view("TableView");
	}

	public function selectAction() {
		if (!Middleware::postMethod()) { return Response::badRequest(); }
		
		$tableNum = $_POST["table_num"];

		$_SESSION["tableNum"] = $tableNum;

		return Response::success();
	}
}
?>