<?php

class SpecialItems
{

    static private $special = array(
        'a' => "Mattt's Omniscience Grand Crown",
        'b' => "Res0's Protectorate Plate Mail",
        'c' => "Dwyn's Storm Magic Amulet",
        'd' => "Jotun's Fury Colossal Sword",
        'e' => "Drdink's Cane of Blind Rage",
        'f' => "Mrquick's Magical Boots of Swiftness",
        'g' => "Jeff's Cluehammer of Doom",
        'h' => "Juliet's Glorious Ring of Sparkliness",
    );

    static public function getSpecialMarker($itemLevel)
    {
        $marker = substr($itemLevel, -1);
        if (is_numeric($marker)) {
            return null;
        }
        return $marker;
    }

    static public function getName($itemLevel)
    {
        $uniqueKey = static::getSpecialMarker($itemLevel);
        if (is_null($uniqueKey)) {
            return null;
        }
        if (!array_key_exists($uniqueKey, static::$special)) {
            return null;
        }
        return static::$special[$uniqueKey];
    }

}
