<?php

namespace Forum\Service;

use Forum\Model\Entity\Topic;
use Forum\Model\Entity\Command\Topic\InsertCommand;
use Forum\Model\Entity\Command\Topic\UpdateCommand;
use Forum\Model\Entity\Command\Topic\DeleteCommand;

class TopicManager
{
    /**
     * @var InsertCommand
     */
    private $insertTopicCommand;
    
    /**
     * @var UpdateCommand
     */
    private $updateTopicCommand;
    
    /**
     * @var DeleteCommand 
     */
    private $deleteTopicCommand;
    
    public function __construct(
        InsertCommand $inertTopicCommand,
        UpdateCommand $updateTopicCommand,
        DeleteCommand $deleteTopicCommand
    )
    {
        $this->insertTopicCommand = $inertTopicCommand;
        $this->updateTopicCommand = $updateTopicCommand;
        $this->deleteTopicCommand = $deleteTopicCommand;
    }
    
    /**
     * @param array $data
     * @return \Forum\Entity\Topic
     */
    public function create(array $data = [])
    {
        $topic = new \Forum\Model\Entity\Topic();
        
        if (array_key_exists("t_id", $data)) {
            $topic->setId($data['t_id']);
        }
        
        if (array_key_exists("t_name", $data)) {
            $topic->setName($data['t_name']);
        }
        
        if (array_key_exists("t_description", $data)) {
            $topic->setDescription($data['t_description']);
        }
        
        if (array_key_exists("t_amount_posts", $data)) {
            $topic->setAmountPosts((int)$data['t_amount_posts']);
        }
        
        if (array_key_exists("t_is_closed", $data)) {
            $closed = false;
            if (intval($data['t_is_closed']) === 1) {
                $closed = true;
            }
            $topic->setIsClosed($closed);
        }
        
        if (array_key_exists("t_created_on", $data)) {
            $topic->setCreatedOn(new \DateTime($data['t_created_on']));
        }
        
        return $topic;
    }
   
    public function save(Topic $topic)
    {
        if(!$topic->getUser() || !$topic->getUser()->getId()) {
            throw new \InvalidArgumentException("Cannot save topic without assigned user");
        } elseif(!$topic->getSection() || !$topic->getSection()->getId()) {
            throw new \InvalidArgumentException("Cannot save topic without assigned section");
        }
        
        if ($topic->getId()) {
            $this->update($topic);
        } else {
            return $this->insert($topic);
        }
    }
    
    private function insert(Topic $topic)
    {
        $this->insertTopicCommand->setTopic($topic);
        return $this->insertTopicCommand->execute();
    }
    
    private function update(Topic $topic)
    {
        $this->updateTopicCommand->setTopic($topic);
        return $this->updateTopicCommand->execute();
    }
    
    public function delete(Topic $topic)
    {
        if(!$topic->getSection() || !$topic->getSection()->getId()) {
            throw new \InvalidArgumentException("Cannot delete topic without assigned section");
        }
        
        $this->deleteTopicCommand->setTopic($topic);
        return $this->deleteTopicCommand->execute();
    }
}

