<?php

class Controller_Api extends Controller
{
    public function action_index(){}
    
    public function action_auth()
    {
        //header("Location:" . Config::get('domain'));
        sleep(1);
        echo true;
    }
    
    public function action_reg()
    {
        sleep(1);
        $data = '';
        
        $username = strtolower(htmlspecialchars($_POST['user']));
        $email = strtolower(htmlspecialchars($_POST['email']));
        $pass = htmlspecialchars($_POST['pass']);
        $pass_confirmed = htmlspecialchars($_POST['pass_confirmed']);
        $gender = htmlspecialchars($_POST['gender']); 
        $date_birthday = htmlspecialchars($_POST['date_bithday']);
        $role = 'unconfirmed';
        
        if($pass != $pass_confirmed)
        {
            $data = "Поля пароль не равны";
        }
        
        $res = Module_Auth::instance()->reg($username, $email, $pass, $gender, $date_birthday, $role);
        
        if(!$res)
        {
            $data = "Пользователь уже зарегистрирыван";
        }
        
        echo $data;
    }
    
    public function action_confirm()
    {
        $params = app::getRouter()->getParams();
        echo $params[0];
    }
    
    public function action_resetpass()
    {
        //header("Location:" . Config::get('domain'));
    }
    
    public function action_test()
    {
        
    }
}
