<?php
class TestController {
    public function TestAction() {
        echo blade()->run("test");
    }

    public function JoinedUsersAction()
    {
        Middleware::postMethod();

        try {
            $tournamentid = 1;
            $stmt = DB::Connection()->prepare("SELECT UserName FROM User INNER JOIN GameStatistics ON User.ID = GameStatistics.UserID WHERE GameStatistics.TournamentID = :tournamentid");
            $stmt->bindValue("tournamentid", $tournamentid);
            $stmt->execute();
            $results = $stmt->fetchAll();
            
            echo blade()->run("ViewParts.JoinedUsers", [
                "users" => $results,
            ]);
        } catch (Exception $e) {
            Redirect::internalServerError();
        }
        //echo blade()->run("ViewParts.joinedUsers");
    }
}
?>