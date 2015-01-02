<?php

namespace Security\Service;

use Security\Model\Entity\User;
use Security\Model\Entity\Command\User\InsertCommand;


class UserManager
{
    /**
     * @var InsertCommand 
     */
    private $insertUserCommand;
    
    public function __construct(InsertCommand $insertUserCommand)
    {
        $this->insertUserCommand = $insertUserCommand;
    }
    
    /**
     * @param array $data
     * @return \Security\Service\User
     */
    public function create(array $data = [])
    {
        $user = new User();
        if (array_key_exists("u_id", $data)) {
            $user->setId($data['u_id']);
        }
        
        if (array_key_exists("u_username", $data)) {
            $user->setUsername($data['u_username']);
        }
        
        if (array_key_exists("u_email", $data)) {
            $user->setEmail($data['u_email']);
        }
        
        if (array_key_exists("u_password", $data)) {
            $user->setPassword($data['u_password']);
        }
        
        if (array_key_exists("u_salt", $data)) {
            $user->setSalt($data['u_salt']);
        }
        
        if (array_key_exists("u_amount_posts", $data)) {
            $user->setAmountPosts($data['u_amount_posts']);
        }
        
        if (array_key_exists("u_created_on", $data)) {
            $user->setCreatedOn(new \DateTime($data['u_created_on']));
        }
        
        return $user;
    }
    
    /**
     * @param User $user
     * @return User
     */
    public function save(User $user)
    {
        $this->insertUserCommand->setUser($user);
        return $this->insertUserCommand->execute();
    }
}

