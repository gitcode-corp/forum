<?php

namespace Forum\Model\Entity\Command\Topic;

use Soft\AbstractCommand;
use Forum\Model\Entity\Topic;

class UpdateCommand extends AbstractCommand
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
        if ($this->topic->isClosed()) {
            $isClosed = 1;
        } else {
            $isClosed = 0;
        }
        
        $sql = "UPDATE topics SET ";
        $sql .= "name='" . $this->escapeString($this->topic->getName()) ."', ";
        $sql .= "description='" . $this->escapeString($this->topic->getDescription()) ."', ";
        $sql .= "is_closed =" . $this->escapeString($isClosed) ." ";
        $sql .= "WHERE id =" .$this->escapeString($this->topic->getId());
        
        return $this->update($sql);
    }
}