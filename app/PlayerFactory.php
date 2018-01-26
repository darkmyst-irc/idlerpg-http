<?php

class PlayerFactory
{

    private $parser = null;

    public function __construct(Parser_Player $parser)
    {
        $this->parser = $parser;
    }

    public function makePlayer(string $row)
    {
        $fields = explode("\t", $row);
        return $this->parser->makePlayer($fields);
    }

    public function makePlayers(array $rows)
    {
        $players = array();
        foreach ($rows as $row) {
            $player = $this->makePlayer($row);

            $key = strtolower($player->getCharacter()->getName());

            $players[$key] = $player;
        }
        return $players;
    }

}
