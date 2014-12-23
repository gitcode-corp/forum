<?php

namespace Forum\Entity\Command;

use Soft\DatabaseConnectionFactory;

class CommandFactory
{
    private static $commands = [];
    
    private static $commandMap = [
        'Section\RetriveAllWithLastTopic' => 'Forum\Entity\Command\Section\RetrieveAllWithLastTopicCommand'
    ];
    
    public static function create($commandAlias)
    {
        self::validate($commandAlias);
        
        if (array_key_exists($commandAlias, self::$commands)) {
            return self::$commands[$commandAlias];
        }
        
        $commandClass = self::$commandMap[$commandAlias];
            
        self::$commands[$commandAlias] = new $commandClass(DatabaseConnectionFactory::create());
        
        return self::$commands[$commandAlias];
    }
    
    private static function validate($commandAlias)
    {
        if (!array_key_exists($commandAlias, self::$commandMap)) {
            throw new \InvalidArgumentException("Wrong command alias: " . $commandAlias);
        }
    }
}
