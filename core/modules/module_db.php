<?php

class Module_DB
{
    private $conn;
    private $tables = array();
    private $table = null;

    public function reset()
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
        $res->execute($data);
        $this->reset();

        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function insert($data)
    {
        if($this->table == null) 
        {
            return false;
        }
        
        $keys = array_keys($data);
        
        $query ="INSERT INTO {$this->table}(`".implode("`,`",$keys)."`) VALUES (:".implode(",:",$keys).")";
        $res = $this->conn->prepare($query);
        $res->execute($data);
        $this->reset();
        
        return $this->conn->lastInsertId();
    }
    
     public function delete($id)
    {
        if($this->table == null) 
        {
            return false;
        }
        
        $res = $this->conn->prepare("DELETE FROM {$this->table}  WHERE id=:id");
        $res -> bindValue(":id", $id, PDO::PARAM_INT);
        $res->execute();
        $this->reset();
    }
}