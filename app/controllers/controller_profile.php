<?php

class Controller_Profile extends Controller
{
    public function action_index()
    {
        $view = new View(null, 'main');
        $view->render();
    }
    
    public function action_addpost()
    {
        $view = new View('addpost', 'main');
        $view->render();
    }
}
