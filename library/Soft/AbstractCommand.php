<?php

namespace Soft;

abstract class AbstractCommand
{
    private $dbConnection;
    
    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }
    
    abstract function execute();
    
    public function fetchAll($sql)
    {
        $result = $this->query($sql);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        return [];
    }
    
    public function fetchOne($sql)
    {
        $result = $this->query($sql);
        if ($result) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    public function insert($sql)
    {
        $this->query($sql);

        return $this->dbConnection->insert_id;
    }
    
    public function update($sql)
    {
        return $this->query($sql);
    }
    
    public function delete($sql)
    {
        return $this->query($sql);
    }
    
    private function query($sql)
    {
        $result = $this->dbConnection->query($sql);

        if ($this->dbConnection->error) {
            throw new \Exception("SQL error: " . $this->dbConnection->error , 500);
        }
        
        return $result;
    }
    
    protected function escapeString($string)
    {
        return $this->dbConnection->real_escape_string($string);
    }
}

