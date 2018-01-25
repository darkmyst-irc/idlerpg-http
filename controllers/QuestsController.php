<?php

class QuestsController extends Controller
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
