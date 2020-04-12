<?php

class TournamentController
{
	public function ListScheduledAction()
	{
		Middleware::postMethod();
		Middleware::isLoggedIn();

		try {
			$stmt = DB::Connection()->prepare("SELECT ID, StartTime FROM Tournament WHERE HasEnded='false' ORDER BY StartTime");
			if ($stmt->execute()) {
				$results = $stmt->fetchAll();

				$html = blade()->run("ViewParts.ScheduledGamesList", [
					"scheduledGames" => $results,
				]);

				Response::success([
					"html" => $html,
				]);
			} else {
				Response::internalServerError();
			}
		} catch (Exception $exception) {
			Response::internalServerError();
		}
	}

	public function AddNewAction()
	{
		Middleware::postMethod();
		Middleware::isAdmin();

		$time = isset($_POST["time"]) ? trim(filter_input(INPUT_POST, "time", FILTER_SANITIZE_STRING)) : "";
		if ($time == "") {
			Response::fail();
		}

		$date = isset($_POST["date"]) ? trim(filter_input(INPUT_POST, "date", FILTER_SANITIZE_STRING)) : "";
		if ($date == "") {
			Response::fail();
		}

		try {
			$stmt = DB::Connection()->prepare("INSERT INTO Tournament(StartTime) VALUES (:startTime)");
			$stmt->bindValue("startTime", $date . " " . $time . ":00");
			$stmt->execute();
			if ($stmt->rowCount() == 1) {
				Response::success([
					"addedTournamentID" => DB::Connection()->lastInsertID(),
				]);
			} else {
				Response::fail();
			}
		} catch (Exception $exception) {
			Response::internalServerError();
		}
	}

	public function RemoveGameAction()
	{
		Middleware::postMethod();
		Middleware::isAdmin();

		$id = isset($_POST["id"]) ? trim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING)) : "";
		if ($id == "") {
			Response::badRequest();
		}

		try {
			$stmt = DB::Connection()->prepare("DELETE FROM Tournament WHERE ID = :id");
			$stmt->bindValue(":id", $id);
			$stmt->execute();

			if ($stmt->rowCount() == 1) {
				Response::success();
			} else {
				Response::fail();
			}

		} catch (Exception $exception) {
			Response::internalServerError();
		}
	}

	public function SelectGameAction()
	{
		Middleware::postMethod();
		Middleware::isLoggedIn();

		$TournamentID =  isset($_POST["id"]) ? trim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING)) : "";
		if ($TournamentID == "") {
			Response::badRequest();
		}

		try {
			$settings = null;
			$isJoined = false;
			$playerList = null;

			{
				$stmt = DB::Connection()->prepare("SELECT Settings FROM Tournament WHERE ID = :id");
				$stmt->bindValue(":id", $TournamentID);
				$stmt->execute();
				$settings = $stmt->fetchColumn();
			}

			{
				$stmt = DB::Connection()->prepare("SELECT UserID FROM GameStatistics WHERE TournamentID = :tournamentID AND UserID = :userID");
				$stmt->bindValue("tournamentID", $TournamentID);
				$stmt->bindValue("userID", $_SESSION["user_id"]);
				$stmt->execute();
				if ($stmt->rowCount() == 1) {
					$isJoined = true;
				}
			}

			{
				$stmt = DB::Connection()->prepare("SELECT UserName FROM User WHERE ID IN (SELECT UserID FROM GameStatistics WHERE TournamentID = :id)");
				$stmt->bindValue(":id", $TournamentID);
				$stmt->execute();

				$playerList = $stmt->fetchAll();
			}

			$html = blade()->run("ViewParts.GameInfo", [
				"isJoined" => $isJoined,
				"tournamentID" => $TournamentID,
				"playerList" => $playerList
			]);

			Response::success([
				"html" => $html,
			]);
		} catch (Exception $exception) {
			Redirect::internalServerError();
		}
	}

	public function joinGameAction()
	{
		Middleware::postMethod();
		Middleware::isLoggedIn();

		$TournamentID = isset($_POST["TournamentID"]) ? trim(filter_input(INPUT_POST, "TournamentID", FILTER_SANITIZE_STRING)) : "";
		if ($TournamentID == "") {
			Response::badRequest();
		}

		try {
			$stmt = DB::Connection()->prepare("INSERT INTO GameStatistics(TournamentID, UserID) VALUES (:TournamentID, :UserID)");
			$stmt->bindValue("TournamentID", $TournamentID);
			$stmt->bindValue("UserID", $_SESSION["user_id"]);
			$stmt->execute();

			if ($stmt->rowCount() == 1) {
				Response::Success();
			} else {
				Response::Fail();
			}
		} catch (Exception $exception) {
			Response::internalServerError();
		}
	}

	public function leaveGameAction(){
		Middleware::postMethod();
		Middleware::isLoggedIn();

		$TournamentID = isset($_POST["TournamentID"]) ? trim(filter_input(INPUT_POST, "TournamentID", FILTER_SANITIZE_STRING)) : "";
		if ($TournamentID == "") {
			Response::badRequest();
		}

		try{
			$stmt = DB::Connection()->prepare("DELETE FROM GameStatistics WHERE TournamentID = :TournamentID AND UserID = :UserID");
			$stmt->bindValue("TournamentID", $TournamentID);
			$stmt->bindValue("UserID", $_SESSION["user_id"]);
			$stmt->execute();

			if ($stmt->rowCount() == 1){
				Response::success();
			} else {
				Response::fail();
			}
		} catch (Exception $exception){
			Response::internalServerError();
		}
	}

	public function SelectGameSettingsAction()
	{
		Middleware::postMethod();
		Middleware::isAdmin();

		$id = isset($_POST["id"]) ? trim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING)) : "";

		try{
			$settings = null;
			$playerList = null;

			{
				$stmt = DB::Connection()->prepare("SELECT DATE( StartTime ) AS date_part, TIME( StartTime ) AS time_part, Settings FROM Tournament WHERE ID = :id");
				$stmt->bindValue(":id", $id);
				$stmt->execute();

				$settings = $stmt->fetch();
			}
			
			{
				$stmt = DB::Connection()->prepare("SELECT ID, UserName FROM User WHERE ID IN (SELECT UserID FROM GameStatistics WHERE TournamentID = :id)");
				$stmt->bindValue(":id", $id);
				$stmt->execute();

				$playerList = $stmt->fetchAll();
			}

			$html = blade()->run("ViewParts.GameSettings", [
				"tournamentID" => $id,
				"playerList" => $playerList,
				"settings" => $settings
			]);

			Response::success([
				"html" => $html,
			]);
		} catch (Exception $exception) {
			Redirect::internalServerError();
		}
	}

	public function ListTablesAction() {
		try {
			$stmt = DB::Connection()->prepare("SELECT ID FROM Tournament WHERE HasStarted=true");
			$stmt->execute();
			$tournamentID = $stmt->fetchColumn();

			if ($tournamentID) {
				$stmt = DB::Connection()->prepare("SELECT DISTINCT CurrentTable FROM GameStatistics WHERE TournamentID=:tournamentID");
				$stmt->bindValue("tournamentID", $tournamentID);
				$stmt->execute();
				$gameStatistics = $stmt->fetchAll();

				$filledTables = array();

				foreach ($gameStatistics as $gameStatistic) {
					$stmt = DB::Connection()->prepare("SELECT UserName FROM User INNER JOIN GameStatistics ON GameStatistics.UserID=User.ID WHERE GameStatistics.TournamentID=:tournamentID AND GameStatistics.CurrentTable=:currentTable");
					$stmt->bindValue("tournamentID", $tournamentID);
					$stmt->bindValue("currentTable", $gameStatistic["CurrentTable"]);
					$stmt->execute();
					array_push($filledTables, $stmt->fetchAll());
				}

				$html = blade()->run("ViewParts.listTables", [
					"tables" => $filledTables,
				]);

				Response::success([
					"html" => $html,
				]);
			} else {
				Response::locked();
			}
		}
		catch (Exception $e) {
			Response::internalServerError();
		}
	}
}
?>