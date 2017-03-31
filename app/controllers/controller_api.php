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
}
