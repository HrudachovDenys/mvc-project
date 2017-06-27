<?php

class Module_Profile
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
    
    public function updateFLName($fname, $lname)
    {
        $key = $_COOKIE["token"];
        
        $token = $this->db->tokens->getAll("`key`=:key", ["key" => $key]);
        
        $this->db->user_profile->updateWhere(["firstname"=>$fname], "`user_id`=:id", ["id"=>(int)$token[0]["user_id"]]);
        $this->db->user_profile->updateWhere(["lastname"=>$lname], "`user_id`=:id", ["id"=>(int)$token[0]["user_id"]]);
    }
    
    public function setCountry($country = null)
    {
        $key = $_COOKIE["token"];
        
        $token = $this->db->tokens->getAll("`key`=:key", ["key" => $key]);
        
        if($country != null)
        {
            $cid = $this->db->countries->getAll("`country`=:country", ["country" => $country]);
            $id = $cid[0]["id"];
        }
        else
        {
            $id = null;
        }
        
        $this->db->user_profile->updateWhere(["country_id"=>$id], "`user_id`=:id", ["id"=>(int)$token[0]["user_id"]]);
    }
    
    public function setAbout($text)
    {
        $key = $_COOKIE["token"];
        
        $token = $this->db->tokens->getAll("`key`=:key", ["key" => $key]);
        
        $this->db->user_profile->updateWhere(["about_me"=>$text], "`user_id`=:id", ["id"=>(int)$token[0]["user_id"]]);
    }
    
    public function getCountry($id = null)
    {
        if($id != null)
        {
            $country = $this->db->countries->getAll("`id`=:id", ["id" => $id]);
            $country = $country[0]["country"];
        }
        else
        {
            $country = $this->db->countries->getAll();
        }
        
        return $country;
    }
    
    public function getCategories()
    {
        return $this->db->categories->getAll();
    }
}
