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

	// dit is een whole ass TODO
	/*
	public function getPlayersAction() {
		$stmt = DB::Connection()->prepare("SELECT UserName FROM User INNER JOIN GameStatistics ON UserID=ID WHERE CurrentTable=:tableNum");
		$stmt->bindValue("tableNum", $_SESSION["tableNum"]);
		$stmt->execute();

		$players = $stmt->fetchAll();

		return Response::view("ViewParts.TablePlayerList", ["players" => $players]);
	}

	public function getBlindsAction() {
		$stmt = DB::Connection()->prepare("SELECT Settings FROM Tournament WHERE HasStarted=true");
		$stmt->execute();

		$settings = new GameSettings();
		$blinds = $settings->load($stmt->fetch());

		return Response::view("ViewParts.TablePlayerList", ["players" => $players]);
	}

	public function getFichesAction() {
		$stmt = DB::Connection()->prepare("SELECT Settings FROM Tournament WHERE HasStarted=true");
		$stmt->execute();

		$players = $stmt->fetchAll();

		return Response::view("ViewParts.TablePlayerList", ["players" => $players]);
	}
	*/
}
?>