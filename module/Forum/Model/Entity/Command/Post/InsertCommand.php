<?php

namespace Forum\Model\Entity\Command\Post;

use Soft\AbstractCommand;
use Forum\Model\Entity\Post;
use Forum\Model\Entity\Command\CommandFactory;
use Security\Model\Entity\Command\CommandFactory AS SecurityCommandFactory;

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
        $sql = "INSERT INTO posts (`topic_id`, `user_id`, `content`) ";
        $sql .= "VALUES(";
        $sql .= "'". $this->escapeString($this->post->getTopic()->getId()) ."', ";
        $sql .= "'". $this->escapeString($this->post->getUser()->getId()) ."', ";
        $sql .= "'". $this->escapeString($this->post->getContent()) ."' ";
        $sql .= ")";
        
        $id = $this->insert($sql);
        $this->post->setId($id);
        
        $command = CommandFactory::create("Topic\UpdatePostData");
        $command->setPost($this->post);
        $command->execute();
        
        $command = SecurityCommandFactory::create("User\UpdateAmountPostCommand");
        $command->setUserId($this->post->getUser()->getId());
        $command->execute();
        
        return $this->post;
    }
}
