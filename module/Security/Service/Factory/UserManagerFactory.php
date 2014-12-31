<?php

namespace Security\Service\Factory;

use Security\Service\UserManager;

class UserManagerFactory
{
    /**
     * @return UserManager
     */
    public static function create()
    {
        return new UserManager();
        
    }
}
