<?php

class PlayerStatus
{

    public function __construct($isOnline, $secondsToNextLevel, $secondsIdled)
    {
        $this->isOnline           = (bool) $isOnline;
        $this->secondsToNextLevel = (int) $secondsToNextLevel;
        $this->secondsIdled       = (int) $secondsIdled;
    }

    public function isOnline()
    {
        return $this->isOnline;
    }

    public function getSecondsToNextLevel()
    {
        return $this->secondsToNextLevel;
    }

    public function getSecondsIdled()
    {
        return $this->secondsIdled;
    }

}
