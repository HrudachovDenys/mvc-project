<?php

class Module_DB
{
    private $conn;
    private $tables = array();
    private $table = null;

    public function __reset()
    {
        $this->table = null;
    }

    public function __construct()
    {
        $config = Config::get('db');

        try
        {
            $this->conn = new PDO("mysql:host={$config['server']};dbname={$config['db']};charset={$config['charset']}",
                $config['user'],
                $config['pass']);

            $res = $this->conn->query('SHOW TABLES');
            $this->tables = array_flip($res->fetchAll(PDO::FETCH_COLUMN));
        }
        catch (Exception $ex)
        {
            $this->tables = $ex->getMessage();
            echo $ex->getMessage();
        }
    }

    public function __get($name)
    {
        if(!isset($this->tables[$name]))
        {
            return false;
        }

        $this->table = '`'.$name.'`';

        return $this;
    }

    public function getAll($where = 1, $data = array())
    {
        if($this->table == null)
        {
            return false;
        }

        $res = $this->conn->prepare("SELECT * FROM ".$this->table." WHERE ".$where);
        echo "SELECT * FROM ".$this->table." WHERE ".$where;
        $res->execute($data);
        $this->__reset();

        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
}