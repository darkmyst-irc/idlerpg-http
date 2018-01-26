<?php

class MapController extends Controller
{

    public function viewAction()
    {
        $view = new View('worldmap');
        $view->render(
            array(
                'players' => $this->getPlayers(),
            )
        );
    }

    public function renderAction()
    {
        session_start();
        if (
            isset($_SESSION['time'])
            && ((time() - $_SESSION['time']) < 20)
        ) {
            header("Location: " . Map::getMapErrorUrl());
            exit(0);
        }
        $_SESSION['time'] = time();

        $map = new Map();
        $map->render($_GET);
    }

}
