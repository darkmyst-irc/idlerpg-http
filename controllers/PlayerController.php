<?php

class PlayerController extends Controller
{

    public function characterAction($character)
    {
        $modifiersToShow = 5;
        if (array_key_exists('all-modifiers', $_GET)) {
            $modifiersToShow = Controller::INFINITE_MODIFIERS;
        }

        $view = new View('player-profile');
        $view->render(
            array(
                'player'    => $this->getPlayer($character),
                'modifiers' => $this->getModifiers($character, $modifiersToShow),
            )
        );
    }

}
