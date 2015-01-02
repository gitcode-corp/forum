<?php

namespace Forum\Model\Entity\Command\Section;

use Soft\AbstractCommand;
use Forum\Model\Entity\Section;
use Forum\Model\Entity\Command\CommandFactory;

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
        $command = CommandFactory::create('Topic\RetrieveAllInSection');
        $command->setSectionId($this->section->getId());
        $topics = $command->execute();

        $command = CommandFactory::create('Topic\Delete');
        foreach ($topics as $topic) {
            $command->setTopic($topic);
            $command->execute();
        }
        
        $sql = "DELETE FROM sections ";
        $sql .= "WHERE id =" .$this->escapeString($this->section->getId());
        
        return $this->delete($sql);
    }
}