<?php

class app
{
    protected static $router;
    
    public static function go($uri)
    {
        self::$router = new Router($uri);
        
        $controller_name = 'Controller_'. self::$router->getController();
        $action_name = "action_".self::$router->getAction();
        
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
    
    private function routeError()
    {
        header("HTTP/1.1 404 Not found");
        header('Location:'.DS.'404') || header('Location:'.DS.DIRROOT.DS.'404');
    }
}
