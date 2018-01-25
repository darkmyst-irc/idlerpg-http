<?php

class Controller_Quests extends Controller
{

    public function showAction()
    {
        $view = new View('quest-profile');
        $view->render(
            array(
                'quest' => $this->getCurrentQuest(),
            )
        );
    }

}
