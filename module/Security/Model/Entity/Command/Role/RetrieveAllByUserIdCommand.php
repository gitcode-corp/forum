<?php

namespace Security\Model\Entity\Command\Role;

use Soft\AbstractCommand;
use Security\Model\Entity\Role;

class RetrieveAllByUserIdCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $userId;
    
    public function setUserId($id)
    {
        $this->userId = $id;
    }
    
    /**
     * @return Role[]
     */
    public function execute()
    {
        $sql = "SELECT r.id AS r_id, r.name AS r_name ";
        $sql .= "FROM security_roles r ";
        $sql .= "INNER JOIN groups_roles gr on gr.security_role_id = r.id ";
        $sql .= "INNER JOIN security_groups g on gr.security_group_id = g.id ";
        $sql .= "INNER JOIN users_groups ug on ug.security_group_id = g.id ";
        $sql .= "INNER JOIN users u on ug.user_id = u.id ";
        $sql .= "WHERE u.id = " . $this->escapeString($this->userId);

        $rows = $this->fetchAll($sql);
       
        $collection = [];
        foreach ($rows as $row) {
            $role = new Role();
            $role->setId($row["r_id"]);
            $role->setName($row["r_name"]);

            $collection[] = $role;
        }
        
        return $collection;
    }
}

