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
        $sql = "UPDATE posts SET ";
        $sql .= "content='" . $this->escapeString($this->post->getContent()) ."' ";
        $sql .= "WHERE id =" .$this->escapeString($this->post->getId());
        
        return $this->update($sql);
    }
}