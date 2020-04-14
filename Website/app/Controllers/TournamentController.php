<?php
class TournamentController
{
	public function ListScheduledAction()
	{
		if (!Middleware::postMethod()) {
			return Response::badRequest();
		};
		if (!Middleware::isLoggedIn()) {
			return Response::notAuthorized();
		};

		try {
			$stmt = DB::Connection()->prepare("SELECT ID, StartTime FROM Tournament WHERE HasEnded='false' ORDER BY StartTime");
			$stmt->execute();
			$results = $stmt->fetchAll();

			return Response::view("ViewParts.ScheduledGamesList", [
				"scheduledGames" => $results,
			]);
		} catch (Exception $exception) {
			Response::internalServerError($exception);
		}
	}

	public function AddNewAction()
	{
		if (!Middleware::postMethod()) {
			return Response::badRequest();
		}
		if (!Middleware::isAdmin()) {
			return Response::notAuthorized();
		}

		$time = isset($_POST["time"]) ? trim(filter_input(INPUT_POST, "time", FILTER_SANITIZE_STRING)) : "";
		if ($time == "") {
			return Response::fail();
		}

		$date = isset($_POST["date"]) ? trim(filter_input(INPUT_POST, "date", FILTER_SANITIZE_STRING)) : "";
		if ($date == "") {
			return Response::fail();
		}

		$settings = new GameSettings();

		try {
			$stmt = DB::Connection()->prepare("INSERT INTO Tournament(StartTime, Settings) VALUES (:startTime, :settings)");
			$stmt->bindValue("startTime", $date . " " . $time . ":00");
			$stmt->bindValue("settings", json_encode($settings, true));
			$stmt->execute();
			if ($stmt->rowCount() == 1) {
				return Response::success([
					"addedTournamentID" => DB::Connection()->lastInsertID(),
				]);
			} else {
				return Response::fail();
			}
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function RemoveGameAction()
	{
		if (!Middleware::postMethod()) {
			return Response::badRequest();
		}
		if (!Middleware::isAdmin()) {
			return Response::notAuthorized();
		}

		$id = isset($_POST["id"]) ? trim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING)) : "";
		if ($id == "") {
			return Response::badRequest();
		}

		try {
			$stmt = DB::Connection()->prepare("DELETE FROM Tournament WHERE ID = :id");
			$stmt->bindValue(":id", $id);
			$stmt->execute();

			if ($stmt->rowCount() == 1) {
				return Response::success();
			} else {
				return Response::fail();
			}
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function SelectGameAction()
	{
		if (!Middleware::postMethod()) {
			return Response::badRequest();
		}
		if (!Middleware::isLoggedIn()) {
			return Response::notAuthorized();
		};

		$TournamentID =  isset($_POST["id"]) ? trim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING)) : "";
		if ($TournamentID == "") {
			return Response::badRequest();
		}

		try {
			$settings = null;
			$isJoined = false;
			$playerList = null; {
				$stmt = DB::Connection()->prepare("SELECT Settings FROM Tournament WHERE ID = :id");
				$stmt->bindValue(":id", $TournamentID);
				$stmt->execute();
				$settings = $stmt->fetchColumn();
			} {
				$stmt = DB::Connection()->prepare("SELECT UserID FROM GameStatistics WHERE TournamentID = :tournamentID AND UserID = :userID");
				$stmt->bindValue("tournamentID", $TournamentID);
				$stmt->bindValue("userID", $_SESSION["user_id"]);
				$stmt->execute();
				if ($stmt->rowCount() == 1) {
					$isJoined = true;
				}
			} {
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

			return Response::success([
				"html" => $html,
			]);
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function joinGameAction()
	{
		if (!Middleware::postMethod()) {
			return Response::badRequest();
		}
		if (!Middleware::isLoggedIn()) {
			return Response::notAuthorized();
		}

		$TournamentID = isset($_POST["TournamentID"]) ? trim(filter_input(INPUT_POST, "TournamentID", FILTER_SANITIZE_STRING)) : "";
		if ($TournamentID == "") {
			return Response::badRequest();
		}

		try {
			$stmt = DB::Connection()->prepare("INSERT INTO GameStatistics(TournamentID, UserID) VALUES (:TournamentID, :UserID)");
			$stmt->bindValue("TournamentID", $TournamentID);
			$stmt->bindValue("UserID", $_SESSION["user_id"]);
			$stmt->execute();

			if ($stmt->rowCount() == 1) {
				return Response::Success();
			} else {
				return Response::Fail();
			}
		} catch (PDOException $exception) {
			return Response::internalServerError($exception);
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function leaveGameAction()
	{
		if (!Middleware::postMethod()) {
			return Response::badRequest();
		}
		if (!Middleware::isLoggedIn()) {
			return Response::notAuthorized();
		}

		$TournamentID = isset($_POST["TournamentID"]) ? trim(filter_input(INPUT_POST, "TournamentID", FILTER_SANITIZE_STRING)) : "";
		if ($TournamentID == "") {
			return Response::badRequest();
		}

		try {
			$stmt = DB::Connection()->prepare("DELETE FROM GameStatistics WHERE TournamentID = :TournamentID AND UserID = :UserID");
			$stmt->bindValue("TournamentID", $TournamentID);
			$stmt->bindValue("UserID", $_SESSION["user_id"]);
			$stmt->execute();

			if ($stmt->rowCount() == 1) {
				return Response::success();
			} else {
				return Response::fail();
			}
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function removeFromGameAction()
	{
		if (!Middleware::postMethod()) {
			return Response::badRequest();
		}
		if (!Middleware::isAdmin()) {
			return Response::notAuthorized();
		}

		$TournamentID = isset($_POST["TournamentID"]) ? trim(filter_input(INPUT_POST, "TournamentID", FILTER_SANITIZE_STRING)) : "";
		if ($TournamentID == "") {
			return Response::badRequest();
		}

		$playerID = isset($_POST["id"]) ? trim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING)) : "";
		if ($playerID == "") {
			return Response::badRequest();
		}

		try {
			$stmt = DB::Connection()->prepare("DELETE FROM GameStatistics WHERE TournamentID = :TournamentID AND UserID = :UserID");
			$stmt->bindValue("TournamentID", $TournamentID);
			$stmt->bindValue("UserID", $playerID);
			$stmt->execute();

			if ($stmt->rowCount() == 1) {
				return Response::success();
			} else {
				return Response::fail();
			}
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function SelectGameSettingsAction()
	{
		if (!Middleware::postMethod()) {
			return Response::badRequest();
		}
		if (!Middleware::isAdmin()) {
			return Response::notAuthorized();
		}

		$id = isset($_POST["id"]) ? trim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING)) : "";
		if ($id == "") {
			return Response::badRequest();
		}

		try {
			$settings = null;
			$playerList = null; {
				$stmt = DB::Connection()->prepare("SELECT DATE( StartTime ) AS date_part, TIME( StartTime ) AS time_part, Settings FROM Tournament WHERE ID = :id");
				$stmt->bindValue(":id", $id);
				$stmt->execute();

				$data = $stmt->fetch();

				$dateTime = ["StartDate" => $data["date_part"], "StartTime" => $data["time_part"]];
				$settings = json_decode($data["Settings"], true);

				asort($settings["chipsList"]);
				ksort($settings["potDivision"]);
			} {
				$stmt = DB::Connection()->prepare("SELECT ID, UserName FROM User WHERE ID IN (SELECT UserID FROM GameStatistics WHERE TournamentID = :id)");
				$stmt->bindValue(":id", $id);
				$stmt->execute();

				$playerList = $stmt->fetchAll();
			}

			return Response::view("ViewParts.GameSettings", [
				"tournamentID" => $id,
				"playerList" => $playerList,
				"settings" => $settings,
				"dateTime" => $dateTime
			]);
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function updateSettingsAction()
	{
		if (!Middleware::postMethod()) {
			return Response::badRequest();
		}
		if (!Middleware::isAdmin()) {
			return Response::notAuthorized();
		}

		$tournamentID = isset($_POST["id"]) ? trim(filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING)) : "";
		$settings = isset($_POST["settings"]) ? $_POST["settings"] : "";
		$time = isset($_POST["startTime"]) ? trim(filter_input(INPUT_POST, "startTime", FILTER_SANITIZE_STRING)) : "";
		$date = isset($_POST["startDate"]) ? trim(filter_input(INPUT_POST, "startDate", FILTER_SANITIZE_STRING)) : "";

		if ($tournamentID == "" || $settings == "" || $time == "" || $date == "") {
			//return Response::badRequest();
		}

		try {
			$stmt = DB::Connection()->prepare("UPDATE Tournament SET Settings = :settings, StartTime = :startTime WHERE ID = :id");
			$stmt->bindValue("id", $tournamentID);
			$stmt->bindValue("startTime", $date . " " . $time);
			$stmt->bindValue("settings", json_encode($settings, true));
			$stmt->execute();

			if ($stmt->rowCount() == 1) {
				return Response::success();
			} else {
				return Response::fail(false);
			}
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function ListTablesAction()
	{
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

				return Response::view("ViewParts.listTables", [
					"tables" => $filledTables,
				]);
			} else {
				return Response::locked();
			}
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}
}
