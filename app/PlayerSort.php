<?php

class PlayerSort
{

    public function sortByLevel($left, $right)
    {
        if ($left->getCharacter()->getLevel() > $right->getCharacter()->getLevel()) {
            return 1;
        }
        if ($left->getCharacter()->getLevel() < $right->getCharacter()->getLevel()) {
            return -1;
        }
        if ($left->getStatus()->getSecondsToNextLevel() < $right->getStatus()->getSecondsToNextLevel()) {
            return 1;
        }
        if ($left->getStatus()->getSecondsToNextLevel() > $right->getStatus()->getSecondsToNextLevel()) {
            return -1;
        }
        return 0;
    }

}
