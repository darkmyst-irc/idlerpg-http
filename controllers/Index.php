<?php

class Controller_Index extends Controller
{

    public function indexAction()
    {
        $view = new View('game-info');
        $view->render(
            array(
            )
        );
    }

}
