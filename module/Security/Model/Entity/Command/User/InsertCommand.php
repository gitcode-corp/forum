<?php

namespace Security\Model\Entity\Command\User;

use Soft\AbstractCommand;
use Security\Model\Entity\User;
use Security\Model\Entity\Command\CommandFactory;
use Security\Model\Entity\UserGroup;

class InsertCommand extends AbstractCommand
{
    /**
     * @var User
     */
    private $user;
    
    public function setUser(User $user)
    {
        $this->user = $user;
    }
    
    public function execute()
    {
        $sql = "INSERT INTO users (`username`, `email`, `password`, `salt`) ";
        $sql .= "VALUES(";
        $sql .= "'". $this->escapeString($this->user->getUsername()) ."', ";
        $sql .= "'". $this->escapeString($this->user->getEmail()) ."', ";
        $sql .= "'". $this->escapeString($this->user->getPassword()) ."', ";
        $sql .= "'". $this->escapeString($this->user->getSalt()) ."' ";
        $sql .= ")";
        
        $id = $this->insert($sql);
        $this->user->setId($id);
        
        $command = CommandFactory::create("Group\RetrieveOneByName");
        $command->setName("USER");
        $group = $command->execute();

        $userGroup = new UserGroup();
        $userGroup->setUser($this->user);
        $userGroup->setGroup($group);
        
        $command = CommandFactory::create("UserGroup\Insert");
        $command->setUserGroup($userGroup);
        $command->execute();
        
        return $this->user;
    }
}