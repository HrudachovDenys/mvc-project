<?php

class Controller_ResetPass extends Controller
{
    public function action_index()
    {
        $view = new View('resetpass', 'main');
        $view->render();
    }
}
