<?php

class GameSettings
{
    public $roundTime;
    public $chipsList;
    public $bigBlind;
    public $potDivision;
    public $pausedOnRoundEnd;

    public function __construct()
    {
        $this->roundTime = 60;
        $this->chipsList = ["Wit" => 0.50, "Rood" => 1];
        $this->bigBlind = 1;
        $this->potDivision = array(60, 30, 10);
        $this->pausedOnRoundEnd = false;

    }

    private function load($data)
    {
        $this->roundTime = $data["roundTime"];
        $this->chipsList = $data["chipsList"];
        $this->bigBlind = $data["bigBlind"];
        $this->potDivision = $data["potDivision"];
        $this->pausedOnRoundEnd = $data["pausedOnRoundEnd"];
    }
}
