<?php

require_once ROOT.DS.'config'.DS.'config.php';

function __autoload($className)
{
    $classPath = ROOT.DS.'core'.DS.'classes'.DS.strtolower($className).'.php';
    $controllerPath = ROOT.DS.'app'.DS.'controllers'.DS.'Controller_'.strtolower($className).'.php';
    $modelPath = ROOT.DS.'app'.DS.'models'.DS.strtolower($className).'.php';
    
    if(file_exists($classPath))
    {
        require_once $classPath;
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
