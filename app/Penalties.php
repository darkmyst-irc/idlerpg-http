<?php

class Penalties
{

    const KICKED = 'getting kicked';
    const LOGOUT = 'logout';
    const MESSAGE = 'messages';
    const NICKCHANGE = 'nick changes';
    const PART = 'channel parts';
    const QUEST = 'quests';
    const QUIT = 'quitting';

    private $penalties = array(
        self::KICKED     => 0,
        self::LOGOUT     => 0,
        self::MESSAGE    => 0,
        self::NICKCHANGE => 0,
        self::PART       => 0,
        self::QUEST      => 0,
        self::QUIT       => 0,
    );

    public function __construct($penaltyKicked, $penaltyLogout, $penaltyMessage, $penaltyNickChange, $penaltyPart, $penaltyQuest, $penaltyQuit)
    {
        $this->penalties[static::KICKED]     = (int) $penaltyKicked;
        $this->penalties[static::LOGOUT]     = (int) $penaltyLogout;
        $this->penalties[static::MESSAGE]    = (int) $penaltyMessage;
        $this->penalties[static::NICKCHANGE] = (int) $penaltyNickChange;
        $this->penalties[static::PART]       = (int) $penaltyPart;
        $this->penalties[static::QUEST]      = (int) $penaltyQuest;
        $this->penalties[static::QUIT]       = (int) $penaltyQuit;
    }

    public function getSeconds($type)
    {
        if (!array_key_exists($type, $this->penalties)) {
            return 0;
        }
        return $this->penalties[$type];
    }

}
