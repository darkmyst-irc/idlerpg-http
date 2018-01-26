<?php

class Item
{

    private $itemData = 0;

    public function __construct($itemData)
    {
        $this->itemData = $itemData;
    }

    public function getLevel()
    {
        return (int) $this->itemData;
    }

    public function getName()
    {
        return SpecialItems::getName($this->itemData);
    }

}
