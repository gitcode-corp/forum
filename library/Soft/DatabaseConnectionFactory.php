<?php

namespace Soft;

use Soft\Exception\ConnectionErrorException;

class DatabaseConnectionFactory
{
    private static $connection;
    
    public static function create()
    {
        if (self::$connection) {
            return self::$connection;
        }
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbName = "forum";

        // Create connection
        $conn = new \mysqli($servername, $username, $password, $dbName);
        
        if ($conn->connect_error) {
            throw new ConnectionErrorException($conn->connect_error);
        }
        
        self::$connection = $conn;
                
        return $conn;
    }
}
