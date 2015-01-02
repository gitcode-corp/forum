<?php

namespace Forum\Service;

use Forum\Model\Entity\Post;
use Forum\Model\Entity\Command\Post\InsertCommand;
use Forum\Model\Entity\Command\Post\UpdateCommand;
use Forum\Model\Entity\Command\Post\RemoveContentCommand;

class PostManager
{
    /**
     * @var InsertCommand
     */
    private $insertPostCommand;
    
    /**
     * @var UpdateCommand
     */
    private $updatePostCommand;
    
    /**
     * @var RemoveContentCommand 
     */
    private $removePostContentCommand;
    
    public function __construct(
        InsertCommand $inertPostCommand,
        UpdateCommand $updatePostCommand,
        RemoveContentCommand  $removePostContent
    )
    {
        $this->insertPostCommand = $inertPostCommand;
        $this->updatePostCommand = $updatePostCommand;
        $this->removePostContent = $removePostContent;
    }
    
    /**
     * @param array $data
     * @return \Forum\Entity\Post
     */
    public function create(array $data = [])
    {
        $post = new \Forum\Model\Entity\Post();
        
        if (array_key_exists("p_id", $data)) {
            $post->setId($data['p_id']);
        }
        
        if (array_key_exists("p_is_edited_by_admin", $data)) {
            $isEditedByAdmin = ($data["p_is_edited_by_admin"] == 1)? true : false;
            $post->setIsEditedByAdmin($isEditedByAdmin);
        }
        
        if (array_key_exists("p_content", $data)) {
            $post->setContent($data['p_content']);
        }
        
        if (array_key_exists("p_created_on", $data)) {
            $post->setCreatedOn(new \DateTime($data['p_created_on']));
        }
        
        return $post;
    }
    
    public function save(Post $post)
    {
        if(!$post->getUser() || !$post->getUser()->getId()) {
            throw new \InvalidArgumentException("Cannot save post without assigned user");
        } elseif(!$post->getTopic() || !$post->getTopic()->getId()) {
            throw new \InvalidArgumentException("Cannot save post without assigned topic");
        }
        elseif(!$post->getTopic()->getSection() || !$post->getTopic()->getSection()->getId()) {
            throw new \InvalidArgumentException("Cannot save post without assigned section");
        }
        
        if ($post->getId()) {
            $this->update($post);
        } else {
            return $this->insert($post);
        }
    }
    
    private function insert(Post $post)
    {
        $this->insertPostCommand->setPost($post);
        return $this->insertPostCommand->execute();
    }
    
    private function update(Post $post)
    {
        $this->updatePostCommand->setPost($post);
        return $this->updatePostCommand->execute();
    }
    
    public function removeContent(Post $post)
    {
        if(!$post->getTopic() || !$post->getTopic()->getId()) {
            throw new \InvalidArgumentException("Cannot delete post without assigned topic");
        }
        elseif(!$post->getTopic()->getSection() || !$post->getTopic()->getSection()->getId()) {
            throw new \InvalidArgumentException("Cannot delete post without assigned section");
        }
        
        $this->removePostContent->setPost($post);
        return $this->removePostContent->execute();
    }
}

