<?php

class Module_Post
{
    private static $instance = null;
    private $db;
    
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
    
    public function addpost($title, $url_title, $text, $category_id)
    {
        $res = $this->db->post_status->getAll("`status`=:status", ['status'=>'moderation']);
        
        $pid = $this->db->posts->insert([
            "title"       => $title,
            "url_title"   => $url_title,
            "text"        => $text,
            "user_id"     => Module_Auth::instance()->getUser()['id'],
            "category_id" => $category_id,
            "status_id"   => $res[0]['id']
        ]);
        
        return $pid != 0;
    }
    
    public function getPosts($category_id = null)
    {
        if($category_id == null)
        {
            $posts = $this->db->posts->getAll();
        }
        else
        {
            $posts = $this->db->posts->getAll("`category_id`=:id", ['id'=>$category_id]);
        }
        
        return $posts;
    }
    
    public function getStatus($id)
    {
        $status = $this->db->post_status->getAll('id=:id', ["id"=>$id]);
        
        return $status[0]['status'];
    }
    
    public function updateStatus($pid, $status)
    {
        $status = $this->db->post_status->getAll('status=:status', ["status"=>$status]);
        
        $this->db->posts->update($pid, ['status_id'=>$status[0]['id']]);
    }
    
    public function getPost($id)
    {
        $post = $this->db->posts->getAll("`id`=:id", ['id'=>$id]);
        
        return $post[0];
    }
    
    public function postsCount($uid)
    {
        $posts = $this->db->posts->getAll("`user_id`=:id", ['id'=>$uid]);
        
        return count($posts);
    }
}
