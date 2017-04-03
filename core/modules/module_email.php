<?php

class Module_Email
{
    private $conn;
    private $email, $pass, $server, $port;
    private $to, $subject, $text;
    private $client = 'The Bat! (v2.00.3) Personal';
    private $headers = array();
    
    public function __construct($email = null, $pass = null, $server = null, $port = null)
    {
        $this->email = isset($email) ? $email : Config::get('email_name');
        $this->pass = isset($pass) ? $pass : Config::get('email_pass');
        $this->server = isset($server) ? $server : Config::get('email_server');
        $this->port = isset($port) ? $port : Config::get('email_port');
        
        $this->addHeader("Content-type:text/html");
        
        $this->conn = fsockopen($this->server, $this->port, $errno, $errstr, 10);
    }
    
    public function __destruct()
    {
        fclose($this->conn);
    }
    
    public function setRecipient($email)
    {
        $this->to = $email;
    }
    
    
    public function setSubject($subject)
    {
        $this->addHeader('Subject: ' . $subject);
    }
    
    public function setText($text)
    {
        $this->text = $text;
    }
    
    public function setPostClient($client)
    {
        $this->client = $client;
    }
    
    private function addHeader($header)
    {
        $this->headers[] = $header . "\r\n";
    }
    
    private function getResponse()
    {
        $data = '';
        while ($str = fgets($this->conn, 255))
        {
            $data .= $str;
            if (substr($str, 3, 1) == ' ')
            {
                break;
            }
        }
        return $data;
    }
    
    private function headersToString()
    {
        $headers = '';
        
        foreach ($this->headers as $header)
        {
            $headers .= $header;
        }
        
        $headers .= "\r\n";
        
        return $headers;
    }
    
    private function sendMessage($msg)
    {
        fputs($this->conn, $msg . "\r\n");
        
        $this->getResponse();
    }
    
    public function send_mail_ru()
    {
        $this->sendMessage('EHLO mail.ru');
        $this->sendMessage('AUTH LOGIN');
        $this->sendMessage(base64_encode($this->email));
        $this->sendMessage(base64_encode($this->pass));
        $this->sendMessage('MAIL FROM: ' . $this->email);
        $this->sendMessage('RCPT TO: ' . $this->to);
        $this->sendMessage('DATA');
        
        $this->addHeader('X-Mailer: ' . $this->client);
        $this->addHeader('To: ' . $this->to);
        $this->addHeader('From: ' . 'admin' . "<$this->email>");
        $headers = $this->headersToString();
        
        $this->sendMessage($headers . $this->text . "\r\n.");

        $this->sendMessage('QUIT');
    }
}