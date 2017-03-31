<?php

require_once ROOT.DS.'config'.DS.'config.php';

function __autoload($className)
{

    $classPath = ROOT.DS.'core'.DS.'classes'.DS.strtolower($className).'.php';
    $modulePath = ROOT.DS.'core'.DS.'modules'.DS.strtolower($className).'.php';
    $controllerPath = ROOT.DS.'app'.DS.'controllers'.DS.'controller_'.strtolower($className).'.php';
    $modelPath = ROOT.DS.'app'.DS.'models'.DS.'model_'.strtolower($className).'.php';
    
    if(file_exists($classPath))
    {
        require_once $classPath;
    }
    elseif(file_exists($modulePath))
    {
        require_once $modulePath;
    }
    elseif(file_exists($controllerPath))
    {
        require_once $controllerPath;
    }
    elseif(file_exists($modelPath))
    {
        require_once $modelPath;
    }
    else
    {
        throw new Exception("Failed to loaded class: $className");
    }
}
