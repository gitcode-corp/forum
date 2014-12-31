<?php

namespace Forum\Model\Entity\Command\Topic;

use Soft\AbstractCommand;
use Forum\Model\Entity\Topic;

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
        
        $sql = "UPDATE sections SET ";
        $sql .= "name='" . $this->escapeString($this->section->getName()) ."', ";
        $sql .= "description='" . $this->escapeString($this->section->getDescription()) ."', ";
        $sql .= "is_closed =" . $this->escapeString($isClosed) ." ";
        $sql .= "WHERE id =" .$this->escapeString($this->section->getId());
        
        return $this->update($sql);
    }
}