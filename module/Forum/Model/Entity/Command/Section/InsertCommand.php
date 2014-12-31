<?php

namespace Forum\Model\Entity\Command\Section;

use Soft\AbstractCommand;
use Forum\Model\Entity\Section;

class InsertCommand extends AbstractCommand
{
    /**
     * @var Section
     */
    private $section;
    
    public function setSection(Section $section)
    {
        $this->section = $section;
    }
    
    public function execute()
    {
        $sql = "INSERT INTO sections (`name`, `description`, `user_id`) ";
        $sql .= "VALUES(";
        $sql .= "'". $this->escapeString($this->section->getName()) ."', ";
        $sql .= "'". $this->escapeString($this->section->getDescription()) ."', ";
        $sql .= $this->escapeString($this->section->getUser()->getId()) ." ";
        $sql .= ")";
        
        $id = $this->insert($sql);
        $this->section->setId($id);
        
        return $this->section;
    }
}