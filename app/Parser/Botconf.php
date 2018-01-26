<?php

class Parser_Botconf
{

    public function getBotconf(array $lines)
    {
        $configuration = array();
        foreach ($lines as $line) {
            if (strpos($line, '#') === 0) {
                continue;
            }
            list($field, $value)  = explode(' ', $line, 2);
            $configuration[$field] = trim($value);
        }
        return $configuration;
    }

}
