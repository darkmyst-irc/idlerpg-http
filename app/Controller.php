<?php

class Controller
{

    private $configuration = array();

    public function __construct($configuration)
    {
        $this->configuration = $configuration;
    }

    public function getPlayers($sortBy = 'name', $reverse = false)
    {
        $playerFactory = new PlayerFactory(new Parser_Player());
        $players = $playerFactory->makePlayers($this->getDatabaseFileLines(), $sortBy);
        ksort($players, SORT_NATURAL);
        if ($reverse) {
            return array_reverse($players);
        }
        return $players;
    }

    public function getPlayer($character)
    {
        $playerFactory = new PlayerFactory(new Parser_Player());
        $lines = $this->getDatabaseFileLines();
        foreach ($lines as $line) {
            $player = $playerFactory->makePlayer($line);
            if ($player->getCharacter()->getName() === $character) {
                return $player;
            }
        }
        return null;
    }

    public function getModifiers($character)
    {
        $modifierFactory = new ModifierFactory(new Parser_Modifier());
        $lines = $this->getModifierFileLines();
        $modifiers = array();
        foreach ($modifierFactory->makeModifiers($lines) as $modifier) {
            if ($modifier->hasCharacterMention($character)) {
                $modifiers[] = $modifier;
            }
        }
        return $modifiers;
    }

    public function getCurrentQuest()
    {
        $parser = new Parser_Quest();
        return $parser->makeQuest($this->getQuestFileLines());
    }

    public function getDatabaseFileLines()
    {
        return array_slice(file($this->configuration['files']['players']), 1);
    }

    public function getModifierFileLines()
    {
        return file($this->configuration['files']['modifiers']);
    }

    public function getQuestFileLines()
    {
        return file($this->configuration['files']['quests']);
    }

}
