<?php

Config::set('site_name', 'mvc-project');

//default controller
Config::set('default_controller', 'main');
//default action
Config::set('default_action', 'index');
//db connection
Config::set('db_conn', include 'db.php');