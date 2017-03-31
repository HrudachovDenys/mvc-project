<?php

Config::set('site_name', 'mvc-project');
Config::set('dir_root', '/mvc-project/');
Config::set('domain', 'http://mvc.localhost/');

//default controller
Config::set('default_controller', 'main');
//default action
Config::set('default_action', 'index');
//db connection
Config::set('db', require 'db.php');