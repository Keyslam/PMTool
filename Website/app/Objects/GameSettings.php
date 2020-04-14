<?php

class GameSettings
{
    public $roundTime;
    public $chipsList;
    public $bigBlind;
    public $potDivision;

    public function __construct()
    {
        $this->roundTime = 60;
        $this->chipsList = ["Wit" => 0.10, "Rood" => 0.20, "Blauw" => 0.50, "Groen" => 2, "Zwart" => 1.00];
        $this->bigBlind = 0.20;
        $this->potDivision = ["1ste" => 60, "2de" => 30, "3de" => 10];
    }
}
