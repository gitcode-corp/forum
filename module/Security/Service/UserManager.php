<?php

namespace Security\Service;

use Security\Model\Entity\User;

class UserManager
{
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
}

