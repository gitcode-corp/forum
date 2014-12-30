<?php

namespace Security\Service\Factory;

use Security\Model\Entity\Command\CommandFactory;

class AuthenticationServiceFactory
{
    public static function create()
    {
        $retrieveByUsernameCommand = CommandFactory::create("User\RetrieveByUsername");
        $retrieveAllByUserIdCommand = CommandFactory::create("Role\RetrieveAllByUserId");
        
        return new \Security\Service\AuthenticationService($retrieveByUsernameCommand, $retrieveAllByUserIdCommand);
    }
}
