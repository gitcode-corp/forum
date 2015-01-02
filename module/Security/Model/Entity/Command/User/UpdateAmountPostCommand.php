<?php

namespace Security\Model\Entity\Command\User;

use Soft\AbstractCommand;

class UpdateAmountPostCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $userId;
    
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    
    public function execute()
    {
        
        $sql = "UPDATE users SET ";
        $sql .= "amount_posts = amount_posts+1 ";
        $sql .= "WHERE id =" .$this->escapeString($this->userId);
        
        return $this->update($sql);
    }
}