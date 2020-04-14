<?php
class TableController {
	public function indexAction() {
		return Response::view("TableView");		
	}

	public function selectAction() {
		if (!Middleware::postMethod()) { return Response::badRequest(); }
		
		$tableNum = $_POST["table_num"];

		$stmt = DB::Connection()->prepare("SELECT ID FROM Tournament WHERE HasStarted=true");
		$stmt->execute();
		$tournamentID = $stmt->fetchColumn();

		$_SESSION["tableNum"] = $tableNum;
		$_SESSION["tournamentID"] = $tournamentID;

		return Response::success();
	}

	public function getPlayersAction() {
		try {
			$stmt = DB::Connection()->prepare("SELECT ID, UserName, HasRebought FROM User INNER JOIN GameStatistics ON UserID=ID WHERE CurrentTable=:tableNum");
			$stmt->bindValue("tableNum", $_SESSION["tableNum"]);
			$stmt->execute();

			$players = $stmt->fetchAll();

			return Response::view("ViewParts.TablePlayerList", [
				"players" => $players, 
			]);
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function getBlindsAction() {
		try {
			$stmt = DB::Connection()->prepare("SELECT Settings FROM Tournament WHERE ID=:tournamentID");
			$stmt->bindValue("tournamentID", $_SESSION["tournamentID"]);
			$stmt->execute();

			$settings = json_decode($stmt->fetch()["Settings"], true);
			$bigBlind = $settings["bigBlind"];
			$smallBlind = round($bigBlind / 2 * 100) / 100;

			return Response::view("ViewParts.TableBlindsList", [
				"bigBlind" => $bigBlind,
				"smallBlind" => $smallBlind,
			]);
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function getFichesAction() {
		try {
			$stmt = DB::Connection()->prepare("SELECT Settings FROM Tournament WHERE ID=:tournamentID");
			$stmt->bindValue("tournamentID", $_SESSION["tournamentID"]);
			$stmt->execute();

			$settings = json_decode($stmt->fetch()["Settings"], true);

			$chipsList = $settings["chipsList"];
			asort($chipsList);

			return Response::view("ViewParts.TableFichesList", [
				"chipsList" => $chipsList,
			]);
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function rebuyAction() {
		if (!Middleware::postMethod()) { return Response::badRequest(); }
		
		$userID = $_POST["id"];

		try {	
			$stmt = DB::Connection()->prepare("SELECT HasRebought FROM GameStatistics WHERE UserID=:userID AND TournamentID=:tournamentID");
			$stmt->bindValue("userID", $userID);
			$stmt->bindValue("tournamentID", $_SESSION["tournamentID"]);
			$stmt->execute();
			$hasRebought = $stmt->fetchColumn();

			$stmt = DB::Connection()->prepare("UPDATE GameStatistics SET HasRebought=true WHERE UserID=:userID AND TournamentID=:tournamentID");
			$stmt->bindValue("userID", $userID);
			$stmt->bindValue("tournamentID", $_SESSION["tournamentID"]);
			
			if (!$stmt->execute()) {
				return Response::fail();
			}

			return Response::success([
				"reboughtSuccess" => !$hasRebought,
			]);
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function winHandAction() {
		if (!Middleware::postMethod()) { return Response::badRequest(); }
		
		$userID = $_POST["id"];

		try {	
			$stmt = DB::Connection()->prepare("UPDATE GameStatistics SET HandsWon=HandsWon+1 WHERE UserID=:userID AND TournamentID=:tournamentID");
			$stmt->bindValue("userID", $userID);
			$stmt->bindValue("tournamentID", $_SESSION["tournamentID"]);
			
			if (!$stmt->execute()) {
				return Response::fail();
			}

			return Response::success();
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}

	public function addHandAction() {
		if (!Middleware::postMethod()) { return Response::badRequest(); }
		
		$userID = $_POST["id"];

		try {	
			$stmt = DB::Connection()->prepare("UPDATE GameStatistics SET HandsPlayed=HandsPlayed+1 WHERE UserID=:userID AND TournamentID=:tournamentID");
			$stmt->bindValue("userID", $userID);
			$stmt->bindValue("tournamentID", $_SESSION["tournamentID"]);
			
			if (!$stmt->execute()) {
				return Response::fail();
			}

			return Response::success();
		} catch (Exception $exception) {
			return Response::internalServerError($exception);
		}
	}
}
?>