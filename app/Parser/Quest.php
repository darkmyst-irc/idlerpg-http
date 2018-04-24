<?php

class Parser_Quest
{

    const KEY_DESCRIPTION   = 'T';
    const KEY_TYPE          = 'Y';
    const KEY_STAGE_OR_TIME = 'S';
    const KEY_GOALS         = 'P';

    const KEY_PLAYER_NAME  = 0;
    const KEY_PLAYER_POS_X = 1;
    const KEY_PLAYER_POS_Y = 2;

    public function makeQuest($lines)
    {
        $questData = array();
        foreach ($lines as $line) {
            list($key, $data) = explode(' ', $line, 2);
            $questData[$key] = $data;
        }

        if (!array_key_exists(static::KEY_TYPE, $questData)) {
            return null;
        }

        return new Quest(
            (int) $this->getFromArray($questData, static::KEY_TYPE),
            $this->getFromArray($questData, static::KEY_DESCRIPTION),
            time() - ((int) $this->getFromArray($questData, static::KEY_STAGE_OR_TIME)),
            $this->extractGoals($questData),
            $this->extractPlayers($questData)
        );
    }

    public function extractGoals($questData)
    {
        $goalData = $this->getFromArray($questData, static::KEY_GOALS);
        if (is_null($goalData)) {
            return null;
        }

        $goalPieces = array_map('trim', explode(' ', $goalData));
        $defaults   = array_fill(0, 4, 0);
        $goalPieces = $goalPieces + $defaults;
        return array(
            1 => array('x' => $goalPieces[0], 'y' => $goalPieces[1]),
            2 => array('x' => $goalPieces[2], 'y' => $goalPieces[3]),
        );
    }

    public function extractPlayers($questData)
    {
        $potentialPlayers = array('P1', 'P2', 'P3', 'P4');

        $players = array();
        foreach ($potentialPlayers as $key) {
            if (array_key_exists($key, $questData)) {
                $playerData = explode(' ', $questData[$key]);
                $players[$key] = array(
                    'name' => $this->getFromArray($playerData, static::KEY_PLAYER_NAME),
                    'x'    => $this->getFromArray($playerData, static::KEY_PLAYER_POS_X),
                    'y'    => $this->getFromArray($playerData, static::KEY_PLAYER_POS_Y),
                );
            }
        }
        return $players;
    }

    public function getFromArray($array, $key)
    {
        if (!array_key_exists($key, $array)) {
            return null;
        }
        return trim($array[$key]);
    }

}
