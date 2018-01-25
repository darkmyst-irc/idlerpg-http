<?php

class Duration
{

    public static function format($seconds)
    {
        $baseLine = new DateTime('@0');
        $seconds  = new DateTime('@' . $seconds);
        return $baseLine->diff($seconds)->format('%a days, %H:%I:%S');
    }

}
