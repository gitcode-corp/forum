<?php

namespace Forum\Model\Entity\Command\Post;

use Soft\AbstractCommand;
use Forum\Model\Entity\Post;

class RemoveContentCommand extends AbstractCommand
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
        $sql .= "content='Post został usunięty przez admina!', ";
        $sql .= "is_edited_by_admin=1 ";
        $sql .= "WHERE id =" .$this->escapeString($this->post->getId());
        
        return $this->update($sql);
    }
}