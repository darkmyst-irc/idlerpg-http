<?php

class PlayerController extends Controller
{

    public function characterAction($character)
    {
        $view = new View('player-profile');
        $view->render(
            array(
                'player'    => $this->getPlayer($character),
                'modifiers' => $this->getModifiers($character),
            )
        );
    }

}
