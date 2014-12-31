<?php

namespace Security\Service;

class GuardService
{
    /**
     * @var AuthenticationService
     */
    private $authenticationService;
    
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService; 
    }
    
    public function isAuthenticated()
    {
        return $this->authenticationService->isUserAuthenticated();
    }
    
    public function isGranted($role)
    {
        if (!$this->isAuthenticated()) {
            return false;
        }
        
        $user = $this->authenticationService->getUser();
        
        return in_array($role, $user['roles']);
    }
    
    public function isAuthUser($userId)
    {
        if (!$this->isAuthenticated()) {
            return false;
        }
        
        $user = $this->authenticationService->getUser();
        
        return $user["id"] === $userId;
    }
    
    public function throwForbiddenException()
    {
        throw new \Soft\Exception\ForbiddenException();
    }
    
    public function throwUnauthorizedException()
    {
        throw new \Soft\Exception\UnauthorizedException();
    }
}
