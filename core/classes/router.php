<?php

class Router
{
    private static $params = null;
    
    public static function getUrlParams()
    {
        if(self::$params != null) return self::$params;
        
        $url = explode("?", $_SERVER['REQUEST_URI'])[0];
        
        $url = array_slice(explode('/', $url), 1)[0] != DIRROOT ? 
                array_slice(explode('/', $url), 1) : 
                array_slice(explode('/', $url), 2);
        
        if(empty($url[(count($url)-1)])) unset($url[(count($url)-1)]);
        
        self::$params = $url;
        
        return $url;
    }
    
    public static function routeError()
    {
        header("HTTP/1.1 404 Not found");
        header('Location:'.DS.'404') || header('Location:'.DS.DIRROOT.DS.'404');
    }
    
    public static function run()
    {
        $params = self::getUrlParams();
        
        $controller_name = 'Controller_'.(empty($params[0]) ? DEF_CONTROLLER : strtolower($params[0]));
        $action_name = "action_".(empty($params[1]) ? DEF_ACTION : strtolower($params[1]));
        
        $controler_path = ROOT.DS.'app'.DS.'controllers'.DS.$controller_name.'.php';
        
        try
        {
            if(!file_exists($controler_path)) {
                throw new Exception ("Not found", 404);
            }
            include $controler_path;
            
            $controller = new $controller_name();
            
            if(!method_exists($controller, $action_name)) {
                throw new Exception("Not found", 404);
            }
            $controller->$action_name();
            
        } 
        catch (Exception $ex) 
        {
            switch($ex->getCode())
            {
                case 404:
                    self::routeError();
                    break;
            }
        }
    }
}