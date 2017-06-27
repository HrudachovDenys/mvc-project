<?php

class Controller_Adm extends Controller
{
    public function action_index()
    {
        header("Location:" . Config::get('domain') . '404');
    }
    
    public function action_users()
    {
        if(Module_Auth::instance()->getRole() == 'admin')
        {
            $view = new View('admusers', 'main');
            $view->render();
        }
        else
        {
            header("Location:" . Config::get('domain') . '404');
        }
    }
    
    public function action_posts()
    {
        if(Module_Auth::instance()->getRole() == 'admin')
        {
            $view = new View('admposts', 'main');
            $view->render();
        }
        else
        {
            header("Location:" . Config::get('domain') . '404');
        }
    }
}