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

//reCaptcha
Config::set('reCaptcha_key', '6LfeGBsUAAAAAPgBaSh9NhYQDg0bTiJe5kjDOVdv');
Config::set('reCaptcha_secredKey', '6LfeGBsUAAAAAEXBNwXPzVYsLHN6uUMLklbkK3Dr');

//email
Config::set('email_name', 'testphpmail@bk.ru');
Config::set('email_pass', 'QazXswEdc');
Config::set('email_server', 'tls://smtp.mail.ru');
Config::set('email_port', 465);