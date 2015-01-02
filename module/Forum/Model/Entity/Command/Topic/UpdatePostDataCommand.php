<?php

namespace Forum\Model\Entity\Command\Topic;

use Soft\AbstractCommand;
use Forum\Model\Entity\Post;

class UpdatePostDataCommand extends AbstractCommand
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
        $sql = "UPDATE topics SET ";
        $sql .= "last_post_id='" . $this->escapeString($this->post->getId()) ."', ";
        $sql .= "amount_posts=amount_posts+1 ";
        $sql .= "WHERE id =" .$this->escapeString($this->post->getTopic()->getId());
        
        return $this->update($sql);
    }
}