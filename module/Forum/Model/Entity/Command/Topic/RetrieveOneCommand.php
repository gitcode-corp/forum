<?php

namespace Forum\Model\Entity\Command\Topic;

use Soft\AbstractCommand;

class RetrieveOneCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $sectionId;
    
    /**
     * @var int
     */
    private $topicId;
    
    public function setSectionId($id)
    {
        $this->sectionId = $id;
    }
    
    public function setTopicId($id)
    {
        $this->topicId = $id;
    }
    
    public function execute()
    {
        $sql = "SELECT s.id AS s_id, s.name AS s_name, s.description AS s_description, s.amount_topics AS t_amount_topics, s.created_on AS s_created_on ";
        $sql .= "FROM sections s ";
        $sql .= "WHERE s.id = " . $this->sectionId . " ";

        $row = $this->fetchOne($sql);
        
        $sectionManager = new \Forum\Service\SectionManager();
        
        return $sectionManager->create($row);
    }
}

