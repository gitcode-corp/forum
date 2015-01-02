<?php

namespace Security\Service\Factory;

use Security\Service\UserManager;
use Security\Model\Entity\Command\CommandFactory;

class UserManagerFactory
{
    /**
     * @return UserManager
     */
    public static function create()
    {
        $insertCommand = CommandFactory::create("User\Insert");
        return new UserManager($insertCommand);
        
    }
}
