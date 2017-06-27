<?php

class Controller_404 extends Controller
{
    public function action_index()
    {
        $view = new View();
        $view->render();
    }
}