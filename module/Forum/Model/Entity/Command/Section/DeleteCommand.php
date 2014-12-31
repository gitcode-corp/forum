<?php

namespace Forum\Model\Entity\Command\Section;

use Soft\AbstractCommand;
use Forum\Model\Entity\Section;

class DeleteCommand extends AbstractCommand
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
        
        $sql = "UPDATE sections SET ";
        $sql .= "name='" . $this->escapeString($this->section->getName()) ."', ";
        $sql .= "description='" . $this->escapeString($this->section->getDescription()) ."', ";
        $sql .= "is_closed =" . $this->escapeString($isClosed) ." ";
        $sql .= "WHERE id =" .$this->escapeString($this->section->getId());
        
        return $this->update($sql);
    }
}