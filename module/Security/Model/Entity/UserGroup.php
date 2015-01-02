<?php

namespace Security\Model\Entity;

use Security\Model\Entity\User;
use Security\Model\Entity\Group;

class UserGroup
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var User
     */
    private $user;
    
    /**
     * @var Group
     */
    private $group;
 
    public function getId()
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }
    
    public function getGroup()
    {
        return $this->group;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    public function setGroup(Group $group)
    {
        $this->group = $group;
        return $this;
    }
}
