<?php

namespace Forum\Model\Entity\Command\Topic;

use Soft\AbstractCommand;
use Forum\Model\Entity\Topic;
use Forum\Model\Entity\Command\CommandFactory;

class InsertCommand extends AbstractCommand
{
    /**
     * @var Topic
     */
    private $topic;
    
    public function setTopic(Topic $topic)
    {
        $this->topic = $topic;
    }
    
    public function execute()
    {
        $sql = "INSERT INTO topics (`name`, `description`, `user_id`, `section_id`) ";
        $sql .= "VALUES(";
        $sql .= "'". $this->escapeString($this->topic->getName()) ."', ";
        $sql .= "'". $this->escapeString($this->topic->getDescription()) ."', ";
        $sql .= $this->escapeString($this->topic->getUser()->getId()) .", ";
        $sql .= $this->escapeString($this->topic->getSection()->getId()) ." ";
        $sql .= ")";
        
        $id = $this->insert($sql);
        $this->topic->setId($id);
        
        $command = CommandFactory::create("Section\UpdateAmountTopic");
        $command->setSectionId($this->topic->getSection()->getId());
        $command->execute();
        
        return $this->topic;
    }
}