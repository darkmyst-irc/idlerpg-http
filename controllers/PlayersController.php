<?php

class PlayersController extends Controller
{

    public function listAction()
    {
        $sortBy = 'level';
        if (array_key_exists('sort', $_GET)) {
            $sortBy = $_GET['sort'];
        }
        $players = $this->getPlayers(
            $sortBy,
            ($sortBy === 'level')
        );

        $view = new View('player-list');
        $view->render(
            array(
                'players' => $players,
            )
        );
    }

}
