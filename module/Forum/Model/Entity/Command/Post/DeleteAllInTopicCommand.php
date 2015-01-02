<?php

namespace Forum\Model\Entity\Command\Post;

use Soft\AbstractCommand;

class DeleteAllInTopicCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $topicId;
    
    public function setTopicId($id)
    {
        $this->topicId = $id;
    }
    
    public function execute()
    {
        
        $sql = "DELETE FROM posts ";
        $sql .= "WHERE topic_id =" .$this->escapeString($this->topicId);
        
        return $this->delete($sql);
    }
}