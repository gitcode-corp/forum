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
    
    private function query($sql)
    {
        $result = $this->dbConnection->query($this->dbConnection->escape_string($sql));

        if ($this->dbConnection->error) {
            throw new \Exception("SQL error: " . $this->dbConnection->error , 500);
        }
        
        return $result;
    }
}

