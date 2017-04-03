<?php

class Module_Auth
{
    private $livetime = 3600*24*30;
    private static $instance = null;
    private $db;
    private $user = null;
    
    private function __construct()
    {
        $this->db = new Module_DB();
    }
    
    public static function instance()
    {
        if(self::$instance === null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function generateSalt($username)
    {
        $hash1 = hash("sha256", $username);
        $hash2 = md5($username);
        return substr($hash1 . $hash2, 3, 10);
    }
    
    private function generateHashPass($pass, $username, $salt)
    {
        $hash1 = hash("sha256", $salt . $pass);
        $hash2 = hash("sha256", $salt . $pass . $username);
        $hash3 = hash("sha256", $pass . $username . $salt);
        $hash4 = sha1($salt . $pass . $username);
        $hash5 = sha1($hash1 . $hash2 . $hash3 . $hash4 . $salt);
        $hash6 = md5($salt . $hash1 . $hash2 . $hash3 . $hash4);
        return md5($hash1 . $hash2 . $hash3 . $hash4 . $hash5 . $hash6 . $salt);
    }
    
    public function is_exists($username)
    {
        $user = $this->db->users->getAll("`username`=:username", ["username" => $username]);
        return count($user) > 0;
    }
    
    public function reg($username, $email, $pass, $gender, $date_birthday, $role)
    {
        if($this->is_exists($username)) 
        {
            return false;
        }
        
        $res = $this->db->roles->getAll("`role`=:role", ["role" => $role]);
        
        if(count($res) == 0) 
        {
            return false;
        }
        
        $salt = $this->generateSalt($username);
        
        $uid = $this->db->users->insert([
            "username" => $username,
            "pass"     => $this->generateHashPass($pass, $username, $salt),
            "salt"     => $salt,
            "email"    => $email
        ]);
        
        if($uid == 0)
        {
            return false;
        }
        
        $pid = $this->db->user_profile->insert([
            "user_id"      => $uid,
            "gender"       => $gender,
            "date_birhday" => $date_birthday
        ]);
        
        if($pid == 0)
        {
            $this->db->users->delete($uid);
            return false;
        }
        
        $rid = $this->db->user_roles->insert([
            "user_id" => $uid,
            "role_id" => $res[0]["id"]
        ]);
        
        if($rid == 0)
        {
            $this->db->users->delete($uid);
            $this->db->user_profile->delete($pid);
            return false;
        }
        
        $res = $this->sendConfirmEmail($uid, $email);
        
        if(!$res)
        {
            $this->db->users->delete($uid);
            $this->db->user_profile->delete($pid);
            $this->db->user_roles->delete($rid);
            return false;
        }
        
        return true;
    }
    
    private function sendConfirmEmail($uid, $to)
    {
        $hash = md5(time() . $uid);
        
        $cid = $this->db->confirm_keys->insert([
            "user_id"  => $uid,
            "hash"     => $hash,
            "expiries" => date('y:m:d', strtotime("+10 days"))
        ]);
        
        if($cid == 0)
        {
            return false;
        }
        
        $email = new Module_Email();
        $email->setRecipient($to);
        $email->setSubject('Подтверждение регистрации');

        $href = Config::get('domain') . 'api/confirm/' . $hash . '/' . $uid;
        $msg = "Перейдите по ссылке что бы подтвердить регистрацию. ";
        $msg .= "<a href='{$href}'>Перейти</a>";

        $email->setText($msg);
        $email->send_mail_ru();
        
        return true;
    }
}