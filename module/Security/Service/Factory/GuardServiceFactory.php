<?php

namespace Security\Service\Factory;

class GuardServiceFactory
{
    /**
     * @return \Security\Service\GuardService
     */
    public static function create()
    {
        $authService = AuthenticationServiceFactory::create();
        return new \Security\Service\GuardService($authService);
        
    }
}