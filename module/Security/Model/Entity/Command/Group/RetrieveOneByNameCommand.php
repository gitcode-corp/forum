<?php

namespace Security\Model\Entity\Command\Group;

use Soft\AbstractCommand;
use Security\Model\Entity\Group;

class RetrieveOneByNameCommand extends AbstractCommand
{
    /**
     * @var string
     */
    private $name;
    
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    public function execute()
    {
        $sql = "SELECT sg.id AS sg_id, sg.name AS sg_name ";
        $sql .= "FROM security_groups sg ";
        $sql .= "WHERE sg.name LIKE '".$this->escapeString($this->name)."'";

        $row = $this->fetchOne($sql);

        if (!$row) {
            return null;
        }
        
        $group = new Group();
        $group->setId($row["sg_id"]);
        $group->setName($row["sg_name"]);
        
        return $group;
    }
}
