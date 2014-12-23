<?php

namespace Forum\Entity\Command;

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
        $result = $this->dbConnection->query($this->dbConnection->escape_string($sql));

        if ($this->dbConnection->error) {
            throw new Exception("SQL error: " . $this->dbConnection->error , 500);
        }
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        return null;
    }
}

