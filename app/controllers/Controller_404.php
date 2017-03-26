<?php

class Controller_404 extends Controller
{
    public function action_index()
    {
        include ROOT.DS.'app'.DS.'templates'.DS.'404.php';
    }
}