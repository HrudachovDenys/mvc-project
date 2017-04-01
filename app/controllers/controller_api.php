<?php

class Controller_Api extends Controller
{
    public function action_index(){}
    
    public function action_auth()
    {
        header("Location:" . Config::get('domain'));
    }
    
    public function action_reg()
    {
        header("Location:" . Config::get('domain'));
    }
    
    public function action_resetpass()
    {
        header("Location:" . Config::get('domain'));
    }
    
    public function action_test()
    {
        Module_Auth::instance()->reg("admin2", "test@tes2t.test", "qwerty", "men", getdate(), "admin");
    }
}
