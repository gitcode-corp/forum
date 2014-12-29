<?php

namespace Forum\Model\Entity\Command\Section;

use Soft\AbstractCommand;

class RetrieveOneCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $sectionId;
    
    public function setSectionId($id)
    {
        $this->sectionId = $id;
    }
    
    public function execute()
    {
        $sql = "SELECT t.id AS t_id, t.name AS t_name, t.description AS t_description, t.amount_posts AS t_amount_posts, t.is_closed AS t_is_closed, t.created_on AS t_created_on ";
        $sql .= "FROM topics t ";
        $sql .= "INNER JOIN sections s on s.id = t.section_id ";
        $sql .= "WHERE s.id = " . $this->sectionId . " ";

        $row = $this->fetchOne($sql);
        
        $topicManager = new \Forum\Service\TopicManager;
        
        return $topicManager->create($row);
    }
}

