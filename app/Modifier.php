<?php

class Modifier
{

    const TYPE_SOLO_CHALLENGE_WON  = 'challenge (won)';
    const TYPE_SOLO_CHALLENGE_LOST = 'challenge (lost)';
    const TYPE_TEAM_CHALLENGE_WON  = 'team battle (won)';
    const TYPE_TEAM_CHALLENGE_LOST = 'team battle (lost)';
    const TYPE_GODSEND             = 'godsend';
    const TYPE_CALAMITY            = 'calamity';
    const TYPE_BLESSING            = 'blessing';
    const TYPE_FORSAKING           = 'forsaking';
    const TYPE_QUEST               = 'quest';
    const TYPE_UNKNOWN             = 'unknown';

    private $when = 0;
    private $type = '';
    private $players = array();
    private $opponents = array();
    private $modifierInSeconds = 0;
    private $rawText = '';

    private $validTypes = array(
        self::TYPE_SOLO_CHALLENGE_WON,
        self::TYPE_SOLO_CHALLENGE_LOST,
        self::TYPE_TEAM_CHALLENGE_WON,
        self::TYPE_TEAM_CHALLENGE_LOST,
        self::TYPE_GODSEND,
        self::TYPE_CALAMITY,
        self::TYPE_BLESSING,
        self::TYPE_FORSAKING,
        self::TYPE_QUEST,
    );

    public function __construct($when, $type, array $players, array $opponents, $modifierInSeconds, $rawText)
    {
        $this->when = (int) $when;
        $this->type = $type;
        $this->players = $players;
        $this->opponents = $opponents;
        $this->modifierInSeconds = (int) $modifierInSeconds;
        $this->rawText = $rawText;
    }

    public function getType()
    {
        if (!array_key_exists($this->type, $this->validTypes)) {
            return static::TYPE_UNKNOWN;
        }
        return $this->validTypes[$this->type];
    }

    public function getPlayers()
    {
        return $this->players;
    }

    public function getOpponents()
    {
        return $this->opponents;
    }

    public function getModifierInSeconds()
    {
        return $this->modifierInSeconds;
    }

    public function getRawText()
    {
        return $this->rawText;
    }

    public function affectsCharacter($character)
    {
        return in_array($character, $this->players);
    }

    public function hasCharacterMention($character)
    {
        return in_array($character, $this->players) || in_array($character, $this->opponents);
    }

}
