<?php

namespace Forum\Model\Entity\Command\Section;

use Soft\AbstractCommand;
use Forum\Model\Entity\Section;

class InsertSectionCommand extends AbstractCommand
{
    /**
     * @var Section
     */
    private $section;
    
    public function setSectionId(Section $section)
    {
        $this->section = $section;
    }
    
    public function execute()
    {
        $sql = "INSERT INTO sections (name, description, user_id) ";
        $sql .= "VALUES(";
        $sql .= $this->section->getName() .", ";
        $sql .= $this->section->getDescription() .", ";
        $sql .= $this->section->getUser()->getId() ." ";
        $sql .= ")";
        $row = $this->fetchOne($sql);
        
        $topicManager = new \Forum\Service\TopicManager;
        
        return $topicManager->create($row);
    }
}