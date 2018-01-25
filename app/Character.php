<?php

class Character
{

    const ALIGNMENT_NEUTRAL = 'neutral';
    const ALIGNMENT_EVIL    = 'evil';
    const ALIGNMENT_GOOD    = 'good';
    const ALIGNMENT_UNKNOWN = 'unknown';

    private $name      = '';
    private $level     = 0;
    private $class     = '';
    private $positionX = 0;
    private $positionY = 0;
    private $alignment = 'n';
    private $inventory = null;

    private $validAlignments = array(
        'e' => self::ALIGNMENT_EVIL,
        'g' => self::ALIGNMENT_GOOD,
        'n' => self::ALIGNMENT_NEUTRAL,
    );

    public function __construct(
        $name,
        $level,
        $class,
        $positionX,
        $positionY,
        $alignment,
        Inventory $inventory
    )
    {
        $this->name      = $name;
        $this->level     = (int) $level;
        $this->class     = $class;
        $this->positionX = (int) $positionX;
        $this->positionY = (int) $positionY;
        $this->alignment = trim($alignment);
        $this->inventory = $inventory;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getPosition()
    {
        return array(
            'x' => $this->positionX,
            'y' => $this->positionY,
        );
    }

    public function getAlignment()
    {
        if (!array_key_exists($this->alignment, $this->validAlignments)) {
            return static::ALIGNMENT_UNKNOWN;
        }
        return $this->validAlignments[$this->alignment];
    }

    public function getInventory(): Inventory
    {
        return $this->inventory;
    }

}