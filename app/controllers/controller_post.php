<?php

class Controller_Post extends Controller
{
    public function action_index()
    {
        $view = new View(null, 'main');
        $view->render();
    }
    
    public function action_preview()
    {
        $view = new View('postpreview', 'main');
        $view->render();
    }
    
    public function action_view()
    {
        $view = new View('view', 'main');
        $view->render();
    }
}