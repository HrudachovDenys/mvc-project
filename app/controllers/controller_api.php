<?php

class Controller_Api extends Controller
{
    public function action_index(){ header("Location:" . Config::get('domain')); }
    
    public function action_auth()
    {
        $data = ["error" => "0"];
        
        $username = strtolower(htmlspecialchars($_POST['user']));
        $pass = htmlspecialchars($_POST['pass']);
        
        $res = Module_Auth::instance()->login($username, $pass);
        
        if(!$res)
        {
            $data["error"] = $res;
        }
        else
        {
            $data["gender"] = Module_Auth::instance()->getGender();
        }
        
        echo json_encode($data);
    }
    
    public function action_reg()
    {
        $data = ["error" => "0"];
        
        $username = strtolower(htmlspecialchars($_POST['user']));
        $email = strtolower(htmlspecialchars($_POST['email']));
        $pass = htmlspecialchars($_POST['pass']);
        $pass_confirmed = htmlspecialchars($_POST['pass_confirmed']);
        $gender = htmlspecialchars($_POST['gender']); 
        $date_birthday = htmlspecialchars($_POST['date_bithday']);
        $role = 'unconfirmed';
        $avatar = $gender == "men" ? "/images/def-avatar-men.png" : "/images/def-avatar-women.png";
        
        if($pass != $pass_confirmed)
        {
            $data["error"] = "Поля пароль не равны";
        }
        
        $res = Module_Auth::instance()->reg($username, $email, $pass, $gender, $date_birthday, $role, $avatar);
        
        if(!$res)
        {
            $data["error"] = "Пользователь уже зарегистрирыван";
        }
        
        echo json_encode($data);
    }
    
    public function action_logout()
    {
        Module_Auth::instance()->logout();
        header("Location:" . Config::get('domain'));
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
    
    public function action_editflname()
    {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        
        Module_Profile::instance()->updateFLName($fname, $lname);
        
        header("Location:" . Config::get('domain') . 'profile');
    }
    
    public function action_setcountry()
    {
        
        Module_Profile::instance()->setCountry($_POST["setcountry"]);
        
        header("Location:" . Config::get('domain') . 'profile');
    }
    
    public function action_editcountry()
    {
        Module_Profile::instance()->setCountry();
        
        header("Location:" . Config::get('domain') . 'profile');
    }
    
    public function action_editabout()
    {
        Module_Profile::instance()->setAbout($_POST["about_text"]);
        
        header("Location:" . Config::get('domain') . 'profile');
    }
    
    public function action_addpost()
    {
        $title = $_POST['title'];
        $url_title = $_POST['url_title'];
        $text = $_POST['text'];
        $category_id = $_POST['category'];
        
        Module_Post::instance()->addpost($title, $url_title, $text, $category_id);
        
        header("Location:" . Config::get('domain'));
    }
    
    public function action_adm_roleupdate()
    {
        $params = app::getRouter()->getParams();
        if($params[0] == '' || $params[1] == '')
        {
            header("Location: " . Config::get('domain') . 'adm/users');
        }
        $uid = $params[0];
        $role = $params[1];
        Module_Auth::instance()->updateRole($uid, $role);
        header("Location: " . Config::get('domain') . 'adm/users');
    }

    public function action_postpublish()
    {
        $params = app::getRouter()->getParams();
        if($params[0] == '' || $params[1] == '')
        {
            header("Location: " . Config::get('domain') . 'adm/posts');
        }
        
        $pid = $params[0];
        $status = $params[1];
        
        Module_Post::instance()->updateStatus($pid, $status);
        header("Location: " . Config::get('domain') . 'adm/posts');
    }

    public function action_test()
    {
        $uid = Module_Auth::instance()->getUser()['id'];
        Module_Auth::instance()->updateRole(2, 'user');
    }
}
