<?php

class Controller_Api extends Controller
{
    public function action_index(){ header("Location:" . Config::get('domain')); }
    
    public function action_auth()
    {
        header("Content-Type: application/json", true);
        //header("Location:" . Config::get('domain'));
        $data = array(
            "error" => '',
            "gender" => '');
        
        $username = strtolower(htmlspecialchars($_POST['user']));
        $pass = htmlspecialchars($_POST['pass']);
        
        $res = Module_Auth::instance()->login($username, $pass);
        
        
        $data["gender"] = Module_Auth::instance()->getGender();
        
        echo json_encode($data);
    }
    
    public function action_reg()
    {
        header("Content-Type: application/json", true);
        $data = array("error" => '');
        
        $username = strtolower(htmlspecialchars($_POST['user']));
        $email = strtolower(htmlspecialchars($_POST['email']));
        $pass = htmlspecialchars($_POST['pass']);
        $pass_confirmed = htmlspecialchars($_POST['pass_confirmed']);
        $gender = htmlspecialchars($_POST['gender']); 
        $date_birthday = htmlspecialchars($_POST['date_bithday']);
        $role = 'unconfirmed';
        
        if($pass != $pass_confirmed)
        {
            $data["error"] = "Поля пароль не равны";
        }
        
        $res = Module_Auth::instance()->reg($username, $email, $pass, $gender, $date_birthday, $role);
        
        if(!$res)
        {
            $data["error"] = "Пользователь уже зарегистрирыван";
        }
        echo json_encode($data);
    }
    
    public function action_confirm()
    {
        $params = app::getRouter()->getParams();
        if($params[0] == '' || $params[1] == '')
        {
            return header("Location: " . Config::get('domain'));
        }
        $res = Module_Auth::instance()->confirmEmail($params[0], $params[1]);
        
        if($res)
        {
            header("Location:" . Config::get('domain'));
        }
    }
    
    public function action_resetpass()
    {
        //header("Location:" . Config::get('domain'));
    }
    
    public function action_test()
    {
       echo Module_Auth::instance()->getGender();
    }
}
