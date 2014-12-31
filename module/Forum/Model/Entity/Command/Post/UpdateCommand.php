<?php

namespace Forum\Model\Entity\Command\Post;

use Soft\AbstractCommand;
use Forum\Model\Entity\Post;

class UpdateCommand extends AbstractCommand
{
    /**
     * @var Post
     */
    private $post;
    
    public function setPost(Post $post)
    {
        $this->post = $post;
    }
    
    public function execute()
    {
        if ($this->section->isClosed()) {
            $isClosed = 1;
        } else {
            $isClosed = 0;
        }
        
        $sql = "UPDATE sections SET ";
        $sql .= "name='" . $this->escapeString($this->section->getName()) ."', ";
        $sql .= "description='" . $this->escapeString($this->section->getDescription()) ."', ";
        $sql .= "is_closed =" . $this->escapeString($isClosed) ." ";
        $sql .= "WHERE id =" .$this->escapeString($this->section->getId());
        
        return $this->update($sql);
    }
}