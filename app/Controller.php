<?php

class Controller
{

    private $configuration = array();

    public function __construct($configuration)
    {
        $this->configuration = $configuration;
    }

    public function getPlayers($sortBy = 'level', $reverse = false)
    {
        $playerFactory = new PlayerFactory(new Parser_Player());
        $players = $playerFactory->makePlayers($this->getDatabaseFileLines());

        $playerSort = new PlayerSort();
        $method     = 'sortBy' . ucfirst($sortBy);
        if (method_exists($playerSort, $method)) {
            usort($players, array($playerSort, $method));
        } else {
            ksort($players);
        }

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
        $dirname  = dirname($this->configuration['general']['botconf']);
        $filename = $dirname . '/' . $this->configuration['botconf']['dbfile'];
        return array_slice(file($filename), 1);
    }

    public function getModifierFileLines()
    {
        $dirname  = dirname($this->configuration['general']['botconf']);
        $filename = $dirname . '/' . $this->configuration['botconf']['modsfile'];
        return file($filename);
    }

    public function getQuestFileLines()
    {
        $dirname  = dirname($this->configuration['general']['botconf']);
        $filename = $dirname . '/' . $this->configuration['botconf']['questfilename'];
        return file($filename);
    }

}
