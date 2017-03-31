<?php

class Router
{
    protected $uri;
    protected $controller;
    protected $action;
    protected $params = array();
    
    public function getUri()
    {
        return $this->uri;
    }
    
    public function getController()
    {
        return $this->controller;
    }
    
    public function getAction()
    {
        return $this->action;
    }
    
    public function getParams()
    {
        return $this->params;
    }
    
    public function __construct($uri)
    {
        $this->uri = explode('/', $uri);
        
        if (empty($this->uri[0]))
        {
            array_shift($this->uri);
        }
        ///////////////////////
        if ($this->uri[0] == Config::get('site_name'))		
        {		
            array_shift($this->uri);		
        }
        ////////////////////////
        
        $this->controller = (!empty($this->uri[0])) ? $this->uri[0] : Config::get("default_controller");
        $this->action = (!empty($this->uri[1])) ? $this->uri[1] : Config::get("default_action");
        $this->params = array_slice($this->uri, 2);
    }
}