<?php

class Controller_Main extends Controller
{
    public function action_index()
    {
        $view = new View();
        $view->render();
    }
}