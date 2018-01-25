<?php

class ModifierFactory
{

    private $parser = null;

    public function __construct(Parser_Modifier $parser)
    {
        $this->parser = $parser;
    }

    public function makeModifier(string $row)
    {
        return $this->parser->makeModifier($row);
    }

    public function makeModifiers(array $rows)
    {
        $modifiers = array();
        foreach ($rows as $row) {
            $modifiers[] = $this->makeModifier($row);
        }
        return $modifiers;
    }

}
