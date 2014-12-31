<?php

namespace Forum\Model\Entity\Command\Post;

use Soft\AbstractCommand;
use Forum\Model\Entity\Post;

class InsertCommand extends AbstractCommand
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
        $sql = "INSERT INTO sections (`name`, `description`, `user_id`) ";
        $sql .= "VALUES(";
        $sql .= "'". $this->escapeString($this->section->getName()) ."', ";
        $sql .= "'". $this->escapeString($this->section->getDescription()) ."', ";
        $sql .= $this->escapeString($this->section->getUser()->getId()) ." ";
        $sql .= ")";
        
        $id = $this->insert($sql);
        $this->section->setId($id);
        
        return $this->section;
    }
}