<?php

class Map
{

    const LABEL_BACKGROUND = 'label-background';
    const LABEL_TEXT       = 'label-text';
    const DEFAULT          = 'default';
    const SET_COLOURS      = 'set-colours';

    private $colours = array();

    public static $configuration = array();

    public function render(array $parameters)
    {
        $map = imagecreatefrompng(static::getMapPath());

        $chromaKey = imagecolorallocate($map, 255, 0, 255);
        imagecolortransparent($map, $chromaKey);

        $default = imagecolorallocate($map, 0, 128, 255); // blue

        $this->colours = array(
            static::DEFAULT => $default,
            static::SET_COLOURS => array(
                $default,
                imagecolorallocate($map, 255, 0, 0) // red
            ),
            static::LABEL_BACKGROUND => imagecolorallocate($map, 102, 51, 0), // brown
            static::LABEL_TEXT => imagecolorallocate($map, 255, 255, 204), // paper
        );

        $dotSets = array();
        if (array_key_exists('dots', $parameters)) {
            $dotSets = static::parseParam($parameters['dots']);
        }

        foreach ($dotSets as $setId => $dotSet) {
            $colour = $this->colours[static::DEFAULT];
            if (array_key_exists($setId, $this->colours[static::SET_COLOURS])) {
                $colour = $this->colours[static::SET_COLOURS][$setId];
            }
            $this->renderDots($map, $dotSet, $colour);
        }

        header("Content-type: image/png");
        imagepng($map);
        imagedestroy($map);
        exit(0);
    }

    public function renderDots($map, $positions, $colour)
    {
        foreach ($positions as $position) {
            $this->renderDot($map, $position, $colour);
        }
    }

    public function renderDot($map, $position, $colour)
    {
        imagefilledellipse(
            $map,
            static::getX($position['x']),
            static::getY($position['y']),
            static::getDotSize(),
            static::getDotSize(),
            $colour
        );

        if (!empty($position['name'])) {
            $this->renderLabel(
                $map,
                static::getX($position['x']) + 10,
                static::getY($position['y']),
                $position['name']
            );
        }
    }

    public function renderLabel($map, $x, $y, $label)
    {
        $width  = imageFontWidth(5);
        $height = imageFontHeight(5);

        imagefilledrectangle(
            $map,
            $x + 6,
            $y - ($height / 2),
            $x + 6 + $width * (strlen($label) + 1),
            $y + ($height / 2),
            $this->colours[static::LABEL_BACKGROUND]
        );

        imagestring(
            $map,
            5,
            $x + 7 + ($width / 2),
            $y - ($height / 2) - 1,
            $label,
            $this->colours[static::LABEL_TEXT]
        );
    }

// -- static functions --------------------------------------------------------

    public static function parseParam($packed)
    {
        $sets = explode('@', $packed);
        foreach ($sets as $which => $set) {
            $dotSet = explode(' ', $set);
            foreach ($dotSet as $pos => $dot) {
                $pieces = explode(',', $dot, 3);
                $x      = array_shift($pieces);
                $y      = array_shift($pieces);
                $dot    = array(
                    'name' => array_shift($pieces),
                    'x'    => $x,
                    'y'    => $y,
                );
                $dotSet[$pos] = $dot;
            }
            $sets[$which] = $dotSet;
        }
        return $sets;
    }

    public static function makeParam($sets)
    {
        foreach ($sets as $which => $set) {
            foreach ($set as $key => $dot) {
                $set[$key] = implode(',', $dot);
            }
            $sets[$which] = implode(' ', $set);
        }
        return implode('@', $sets);
    }

    public static function getX($rawX)
    {
        return floor($rawX / (static::getWorldWidth() / static::getMapWidth()));
    }

    public static function getY($rawY)
    {
        return floor($rawY / (static::getWorldHeight() / static::getMapHeight()));
    }

    public static function setConfiguration(array $configuration)
    {
        static::$configuration = $configuration;
    }

    public static function getMapWidth()
    {
        return static::$configuration['maps']['visual_map_width'];
    }

    public static function getMapHeight()
    {
        return static::$configuration['maps']['visual_map_height'];
    }

    public static function getWorldWidth()
    {
        return static::$configuration['botconf']['mapx'];
    }

    public static function getWorldHeight()
    {
        return static::$configuration['botconf']['mapy'];
    }

    public static function getDotSize()
    {
        return static::$configuration['maps']['dot_size'];
    }

    public static function getMapPath()
    {
        return static::$configuration['maps']['map_file'];
    }

    public static function getMapErrorUrl()
    {
        return static::$configuration['maps']['map_error_url'];
    }

}
