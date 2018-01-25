<?php

class Quest
{

    private $type        = 0;
    private $description = '';
    private $time        = null;
    private $stage       = null;
    private $goals       = null;
    private $players     = array();

    public function __construct(int $type, $description, int $stageOrTime, $goals, array $players)
    {
        $this->type = $type;
        $this->description = $description;
        if ($type === 1) {
            $this->time = $stageOrTime;
        } else {
            $this->stage = $stageOrTime;
        }
        $this->goals   = $goals;
        $this->players = $players;
    }

    public function getType()
    {
        return $this->type;
        // @todo what even is this? Can we give it an english-speaking name?
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getStage()
    {
        return $this->stage;
    }

    public function getCurrentGoal()
    {
        if (!array_key_exists($this->stage, $this->goals)) {
            return null;
        }
        return $this->goals[$this->stage];
    }

    public function getInvolvedPlayers()
    {
        return $this->players;
    }

}
