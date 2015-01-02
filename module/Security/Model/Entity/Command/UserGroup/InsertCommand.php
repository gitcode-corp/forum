<?php

namespace Security\Model\Entity\Command\UserGroup;

use Soft\AbstractCommand;
use Security\Model\Entity\UserGroup;


class InsertCommand extends AbstractCommand
{
    /**
     * @var UserGroup
     */
    private $userGroup;
    
    public function setUserGroup(UserGroup $userGroup)
    {
        $this->userGroup = $userGroup;
    }
    
    
    public function execute()
    {

        $sql = "INSERT INTO users_groups (`user_id`, `security_group_id`) ";
        $sql .= "VALUES(";
        $sql .= "'". $this->escapeString($this->userGroup->getUser()->getId()) ."', ";
        $sql .= "'". $this->escapeString($this->userGroup->getGroup()->getId()) ."' ";
        $sql .= ")";
        
        $id = $this->insert($sql);
        $this->userGroup->setId($id);
        
        return $this->userGroup;
    }
}