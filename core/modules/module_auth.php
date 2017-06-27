<?php

class Module_Auth
{
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
    
    public function reg($username, $email, $pass, $gender, $date_birthday, $role, $avatar)
    {
         if($this->is_login())
        {
            return false;
        }
        
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
            "date_birhday" => $date_birthday,
            "uri_avatar"   => $avatar
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
        
        //$this->sendConfirmEmail($uid, $email);
        
        return true;
    }
    
    public function getRoles()
    {
        $roles = $this->db->roles->getAll();
        
        return $roles;
    }
    
    public function getRole($uid = null)
    {
        if($uid == null)
        {
            $uid = $this->getUser()['id'];
        }
        $rid = $this->db->user_roles->getAll("user_id=:id", ["id" => $uid]);
        
        $role = $this->db->roles->getAll('`id`=:id', ['id'=>$rid[0]['role_id']]);
        
        return $role[0]['role'];
    }
    
    public function sendConfirmEmail($uid, $to)
    {
        $hash = md5(time() . $uid);
        
        $cid = $this->db->confirm_keys->insert([
            "user_id"  => $uid,
            "hash"     => $hash,
            "expiries" => date('y:m:d H:i:s', strtotime("+10 days"))
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
    
    public function confirmEmail($hash, $uid)
    {
        $c_keys = $this->db->confirm_keys->getAll("`user_id`=:id", ["id" => $uid]);

        if($c_keys[0]["hash"] != $hash)
        {
            return false;
        }
        
        if($c_keys["expiries"] > date('y:m:d'))
        {
            $user = $this->db->users->getAll("`id`=:id", ["id" => $uid]);
            $this->sendConfirmEmail($uid, $user["email"]);
            return false;
        }

        $rid = $this->db->roles->getAll("`id`=:id", ["id" => $urid[0]["role_id"]]);
        
        if($rid[0]["role"] == "unconfirmed")
        {
            updateRole($uid, 'user');
        }
        else
        {
            return false;
        }
        
        return true;
    }
    
    public function updateRole($uid, $role)
    {
        $urid = $this->db->user_roles->getAll("user_id=:id", ["id" => $uid]);
        
        $rid = $this->db->roles->getAll("`role`=:role", ["role" => $role]);
        
        $this->db->user_roles->update($urid[0]["id"], ["role_id" => $rid[0]['id']]);
    }
    
    private function getIp()
    {
        return (!empty($_SERVER["HTTP_CLIENT_IP"])) ? $_SERVER["HTTP_CLIENT_IP"] :
            ((!empty($_SERVER["HTTP_X_FORWARDER_FOR"])) ? $_SERVER["HTTP_X_FORWARDER_FOR"] :
            ((!empty($_SERVER["REMOTE_ADDR"])) ? $_SERVER["REMOTE_ADDR"] : "0.0.0.0"));
    }
    
    public function login($username, $pass)
    {
        if($this->is_login())
        {
            return false;
        }
        
        $user = $this->db->users->getAll("`username`=:username", ["username" => $username]);
        
        if(count($user) == 0) 
        {
            return "Пользователь не зарегестрирыван";
        }
        
        $user = $user[0];
        
        if($user["pass"] != $this->generateHashPass($pass, $username, $user["salt"]))
        {
            return "Неверный пароль";
        }
        
        $this->user = $user;
        
        return $this->createSession($user["id"]);
    }
    
    private function createSession($uid)
    {
        $ip = $this->getIp();
        $client = $_SERVER["HTTP_USER_AGENT"];
        
        $timestamp = time() + (86400 * 30);
        
        $data = array(
            "user_id"  => $uid,
            "key"      => $this->generateSessionKey($ip, $client, $uid),
            "ip"       => $ip,
            "browser"  => $client,
            "expiries" => date('y:m:d H:i:s', $timestamp)
        );
        
        $tid = $this->db->tokens->insert($data);
        
        if($tid == 0)
        {
            return false;
        }
        
        setcookie("token", $data["key"], $timestamp, "/");
        
        return true;
    }
    
    private function generateSessionKey($ip, $client, $uid)
    {
        $hash1 = hash("sha256", $ip);
        $hash2 = hash("sha256", $ip . $client);
        $hash3 = hash("sha256", $ip . $client . $uid);
        $hash4 = sha1($ip . $client . $uid);
        $hash5 = sha1($hash1 . $hash2 . $hash3 . $hash4);
        $hash6 = md5($hash1 . $hash2 . $hash3 . $hash4 . $hash5);
        
        $subkey = sha1(date('y:m:d H:i:s'));
        $subkey = substr($subkey, 0, 5);
        
        return md5($hash1 . $hash2 . $hash3 . $hash4 . $subkey . $hash5 . $hash6) . $subkey;
    }
    
    public function is_login()
    {
        if($this->user != null) 
        {
            return true;
        }
        
        if(empty($_COOKIE["token"]))
        {
            return false;
        }
        
        $key = $_COOKIE["token"];
        
        $token = $this->db->tokens->getAll("`key`=:key",["key" => $key]);
        
        if(count($token) == 0)
        { 
            return false;
        }
        
        $token = $token[0];
        
        if($token["expiries"] > time())
        { 
            return false;
        }
        
        return $this->validateSession($key, $token["ip"], $token["browser"], $token["user_id"]);
    }
    
    private function validateSession($key, $ip, $client, $uid)
    {
        $hash1 = hash("sha256", $ip);
        $hash2 = hash("sha256", $ip . $client);
        $hash3 = hash("sha256", $ip . $client . $uid);
        $hash4 = sha1($ip . $client . $uid);
        $hash5 = sha1($hash1 . $hash2 . $hash3 . $hash4);
        $hash6 = md5($hash1 . $hash2 . $hash3 . $hash4 . $hash5);
        
        $subkey = substr($key, strlen($key) - 5);
        
        return md5($hash1 . $hash2 . $hash3 . $hash4 . $subkey . $hash5 . $hash6) . $subkey == $key;
    }
    
    public function getUser($uid = null)
    {
        $key = $_COOKIE["token"];
        
        $token = $this->db->tokens->getAll("`key`=:key", ["key" => $key]);
        
        if($uid == null)
        {
            $uid = $token[0]["user_id"];
        }
        
        $userprofile = $this->db->user_profile->getAll("user_id=:id", ["id" => $uid]);
        $userinfo = $this->db->users->getAll("id=:id", ["id" => $uid]);
        
        $user = array_merge($userprofile[0], $userinfo[0]);
        
        return $user;
    }
    
    public function getUsers()
    {
        $users = $this->db->users->getAll();
        
        return $users;
    }
    
    public function logout()
    {
        if(empty($_COOKIE["token"])) 
        {
            return;
        }
        
        $key = $_COOKIE["token"];
        
        $this->db->tokens->deleteWhere("`key`=:key", ["key" => $key]);
    }
}