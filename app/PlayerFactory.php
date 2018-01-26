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

    public function makePlayers(array $rows, $keySource = 'name')
    {
        $players = array();
        foreach ($rows as $row) {
            $player = $this->makePlayer($row);

            $key = strtolower($player->getCharacter()->getName());

            $method = 'get' . ucfirst($keySource);
            if (method_exists($player->getCharacter(), $method)) {
                $key = strtolower($player->getCharacter()->$method()) . '-' . $key;
            }

            $players[$key] = $player;
        }
        return $players;
    }

}
