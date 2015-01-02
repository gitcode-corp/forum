<?php

namespace Forum\Model\Entity\Command\Topic;

use Soft\AbstractCommand;
use Forum\Model\Entity\Topic;
use Forum\Model\Entity\Command\CommandFactory;

class DeleteCommand extends AbstractCommand
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
        $command = CommandFactory::create('Post\DeleteAllInTopic');
        $command->setTopicId($this->topic->getId());
        $command->execute();
        
        $command = CommandFactory::create('Section\UpdateAmountTopic');
        $command->setSectionId($this->topic->getSection()->getId());
        $command->decrease();
        $command->execute();
        
        $sql = "DELETE FROM topics ";
        $sql .= "WHERE id =" .$this->escapeString($this->topic->getId());
        
        return $this->delete($sql);
    }
}