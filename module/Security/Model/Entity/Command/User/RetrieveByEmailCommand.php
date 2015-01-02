<?php

namespace Security\Model\Entity\Command\User;

use Soft\AbstractCommand;
use Security\Service\Factory\UserManagerFactory;

class RetrieveByEmailCommand extends AbstractCommand
{
    /**
     * @var string
     */
    private $email;
    
    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function execute()
    {
        $sql = "SELECT u.id AS u_id, u.username AS u_username, u.password AS u_password, u.salt AS u_salt, u.amount_posts AS u_amount_posts, u.created_on AS u_created_on ";
        $sql .= "FROM users u ";
        $sql .= "WHERE u.email LIKE '".$this->escapeString($this->email)."'";

        $row = $this->fetchOne($sql);

        if (!$row) {
            return null;
        }
        
        $userManager = UserManagerFactory::create();
        
        return $userManager->create($row);
    }
}
