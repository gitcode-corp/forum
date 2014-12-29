<?php

namespace Soft;

abstract class AbstractCommandFactory
{
    private static $commands = [];
    protected static $commandMap = [];
    
    public static function create($commandAlias)
    {
        self::validate($commandAlias);
        
        if (array_key_exists($commandAlias, self::$commands)) {
            return self::$commands[$commandAlias];
        }
        
        $commandClass = static::$commandMap[$commandAlias];
            
        self::$commands[$commandAlias] = new $commandClass(DatabaseConnectionFactory::create());
        
        return self::$commands[$commandAlias];
    }
    
    private static function validate($commandAlias)
    {
        if (!array_key_exists($commandAlias, static::$commandMap)) {
            throw new \InvalidArgumentException("Wrong command alias: " . $commandAlias);
        }
    }
}