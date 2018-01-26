<?php

class Inventory
{

    const AMULET   = 'amulet';
    const BOOTS    = 'boots';
    const CHARM    = 'charm';
    const GLOVES   = 'gloves';
    const HELM     = 'helm';
    const LEGGINGS = 'leggings';
    const RING     = 'ring';
    const SHIELD   = 'shield';
    const TUNIC    = 'tunic';
    const WEAPON   = 'weapon';

    private $inventory = array(
        self::AMULET   => 0,
        self::BOOTS    => 0,
        self::CHARM    => 0,
        self::GLOVES   => 0,
        self::HELM     => 0,
        self::LEGGINGS => 0,
        self::RING     => 0,
        self::SHIELD   => 0,
        self::TUNIC    => 0,
        self::WEAPON   => 0,
    );

    public function __construct(
        Item $amulet,
        Item $boots,
        Item $charm,
        Item $gloves,
        Item $helm,
        Item $leggings,
        Item $ring,
        Item $shield,
        Item $tunic,
        Item $weapon
    )
    {
        $this->inventory[static::AMULET]   = $amulet;
        $this->inventory[static::BOOTS]    = $boots;
        $this->inventory[static::CHARM]    = $charm;
        $this->inventory[static::GLOVES]   = $gloves;
        $this->inventory[static::HELM]     = $helm;
        $this->inventory[static::LEGGINGS] = $leggings;
        $this->inventory[static::RING]     = $ring;
        $this->inventory[static::SHIELD]   = $shield;
        $this->inventory[static::TUNIC]    = $tunic;
        $this->inventory[static::WEAPON]   = $weapon;
    }

    public function getItem($type)
    {
        if (!array_key_exists($type, $this->inventory)) {
            return null;
        }
        return $this->inventory[$type];
    }

}
