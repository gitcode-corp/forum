<?php

namespace Security\Service;

use Security\Model\Entity\Command\User\RetrieveByUsernameCommand;
use Security\Model\Entity\Command\Role\RetrieveAllByUserIdCommand;

class AuthenticationService
{
    /**
     * @var RetrieveUserByUsernameCommand
     */
    private $retrieveUserByUsernameCommand;
    
    private $retrieveAllUserRolesCommand;
    
    /**
     * @param RetrieveByUsernameCommand $retrieveUserByUsernameCommand
     * @param RetrieveAllByUserIdCommand $retrieveAllUserRolesCommand
     */
    public function __construct(
            RetrieveByUsernameCommand $retrieveUserByUsernameCommand,
            RetrieveAllByUserIdCommand $retrieveAllUserRolesCommand
    )
    {
        $this->retrieveUserByUsernameCommand = $retrieveUserByUsernameCommand;
        $this->retrieveAllUserRolesCommand = $retrieveAllUserRolesCommand;
    }
    
    public function authenticate($username, $password)
    {
        $this->retrieveUserByUsernameCommand->setUsername($username);
        $user = $this->retrieveUserByUsernameCommand->execute();

        if (!$user) {
            return false;
        }

        $password = PasswordGenerator::generate($password, $user->getSalt());
        if ($user->getPassword() !== $password["password"]) {
           return false; 
        }
        $this->retrieveAllUserRolesCommand->setUserId($user->getId());
        $roles = $this->retrieveAllUserRolesCommand->execute();
        
        $roleName = [];
        foreach ($roles as $role) {
            $roleName[] = $role->getName();
        }
        
        $sessionData = [
            "id" => $user->getId(), 
            "username" => $user->getUsername(), 
            "roles" => $roleName,
            "token" => substr(md5(rand()), 10, 15)
        ];
        
        \Soft\Session::set("USER", $sessionData);
        
        return true;
    }
    
    public function isUserAuthenticated()
    {
        if ($this->getUser()) {
            return true;
        }
        
        return false;
    }
    
    public function getUser()
    {
        return \Soft\Session::get("USER");
    }
    
    public function clear()
    {
        \Soft\Session::regenerateId(true);
        \Soft\Session::destroy();
    }
}
