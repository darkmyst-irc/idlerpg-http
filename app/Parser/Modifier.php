<?php

class Parser_Modifier
{

    private $keyphrases = array(
        Modifier::TYPE_SOLO_CHALLENGE_WON  => array('] has challenged', 'and won!',),
        Modifier::TYPE_SOLO_CHALLENGE_LOST => array('] has challenged', 'and lost!',),
        Modifier::TYPE_TEAM_CHALLENGE_WON  => array('] have team battled ', 'and won!',),
        Modifier::TYPE_TEAM_CHALLENGE_LOST => array('] have team battled ', 'and lost!',),
        Modifier::TYPE_GODSEND             => array('This wondrous godsend has accelerated them',),
        Modifier::TYPE_CALAMITY            => array('This terrible calamity has slowed them',),
        Modifier::TYPE_BLESSING            => array('Verily I say unto thee, the Heavens have burst forth, and the blessed hand of God carried',),
        Modifier::TYPE_FORSAKING           => array('prudence and self-regard has brought the wrath of the gods upon the realm',),
        Modifier::TYPE_QUEST               => array('have blessed the realm by completing their quest',),
    );

    public function makeModifier($row)
    {
        $when      = $this->extractTimestamp($row);
        $type      = $this->extractType($row);
        $players   = $this->extractPlayers($row, $type);
        $opponents = $this->extractOpponents($row, $type);

        $modifierInSeconds = $this->extractModifierInSeconds($row, $type);

        return new Modifier($when, $type, $players, $opponents, $modifierInSeconds, $row);
    }

    public function extractTimestamp($row)
    {
        list($timestamp) = explode(']', $row, 2);
        return strtotime(ltrim($timestamp, '['));
    }

    public function extractType($row)
    {
        foreach ($this->keyphrases as $type => $keyphrases) {
            $matches = true;
            foreach ($keyphrases as $keyphrase) {
                $matches = $matches && (strpos($row, $keyphrase) !== false);
            }
            if ($matches) {
                return $type;
            }
        }

        // ...uh?
        return Modifier::TYPE_UNKNOWN;
    }

    public function extractPlayers($row, $type)
    {
        list(,$row) = explode(']', $row, 2);
        $row = trim($row);
        if (in_array($type, array(Modifier::TYPE_TEAM_CHALLENGE_WON, Modifier::TYPE_TEAM_CHALLENGE_LOST))) {
            list($playerList) = explode('[', $row, 2);
            list($playerList, $lastPlayer) = explode(' and ', $playerList);
            $players = array_filter(explode(',', $playerList));
            $players[] = $lastPlayer;
            return array_map('trim', $players);
        } else if ($type === Modifier::TYPE_QUEST) {
            list($playerList) = explode($this->keyphrases[Modifier::TYPE_QUEST][0], $row);
            list($playerList, $lastPlayer) = explode(' and ', $playerList);
            $players = array_filter(explode(',', $playerList));
            $players[] = $lastPlayer;
            return array_map('trim', $players);
        } else if ($type === Modifier::TYPE_BLESSING) {
            $strip  = $this->keyphrases[Modifier::TYPE_BLESSING][0];
            $row    = substr($row, strlen($strip) + 1);
            $pieces = explode(' ', $row);
            return array(array_shift($pieces));
        }
        $pieces = explode(' ', $row);
        return array(array_shift($pieces));
    }

    public function extractOpponents($row, $type)
    {
        list(,$row) = explode(']', $row, 2);
        $row = trim($row);

        if (in_array($type, array(Modifier::TYPE_TEAM_CHALLENGE_WON, Modifier::TYPE_TEAM_CHALLENGE_LOST))) {
            list(,$row) = explode($this->keyphrases[Modifier::TYPE_TEAM_CHALLENGE_WON][0], $row, 2);
            list($playerList) = explode('[', $row);

            list($playerList, $lastPlayer) = explode(' and ', $playerList);
            $players = array_filter(explode(',', $playerList));
            $players[] = $lastPlayer;
            return array_map('trim', $players);
        } else if (in_array($type, array(Modifier::TYPE_SOLO_CHALLENGE_WON, Modifier::TYPE_SOLO_CHALLENGE_LOST))) {
            list(,$stringWithPlayer) = explode('[', $row, 3);
            $words = array_filter(explode(' ', $stringWithPlayer));
            return array(trim(end($words)));
        }
        return array();
    }

    public function extractModifierInSeconds($row, $type)
    {
        if ($type === Modifier::TYPE_UNKNOWN) {
            return 0;
        }
        if (strpos($row, '%') !== false) {
            return 0 - ((int) substr($row, strpos($row, '%') - 2, 2));
        }
        if (strpos($row, 'days,') !== false) {
            list($dayRow, $timeRow) = explode('days,', $row);
            $words    = explode(' ', $dayRow);
            $dayCount = end($words);
            $words    = explode(' ', $timeRow);
            $time     = reset($words);
            return strtotime($dayCount . 'days, ' . $time);
        }
        return 0;
    }

}

/*
//     public function __construct($type, array $players, array $opponents, $modifierInSeconds, $rawText)

unaccounted for:
[01/22/18 00:48:56] Alex left his weapon out in the rain to rust! Alex's weapon loses 10% of its effectiveness.
*/