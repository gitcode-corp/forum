<?php

namespace Security\Model\Entity\Command\User;

use Soft\AbstractCommand;

class RetrieveByUsernameCommand extends AbstractCommand
{
    /**
     * @var string
     */
    private $username;
    
    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function execute()
    {
        $sql = "SELECT u.id AS u_id, u.username AS u_username, u.password AS u_password, u.salt AS u_salt, u.amount_posts AS u_amount_posts, u.created_on AS u_created_on ";
        $sql .= "FROM users u ";
        $sql .= "WHERE u.username LIKE '".$this->escapeString($this->username)."'";

        $row = $this->fetchOne($sql);

        if (!$row) {
            return null;
        }
        
        $userManager = new \Security\Service\UserManager();
        
        return $userManager->create($row);
    }
}
