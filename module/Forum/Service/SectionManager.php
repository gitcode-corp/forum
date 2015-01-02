<?php

namespace Forum\Service;

use Forum\Model\Entity\Section;
use Forum\Model\Entity\Command\Section\InsertCommand;
use Forum\Model\Entity\Command\Section\UpdateCommand;
use Forum\Model\Entity\Command\Section\DeleteCommand;

class SectionManager
{
    /**
     * @var InsertCommand
     */
    private $insertSectionCommand;
    
    /**
     * @var UpdateCommand
     */
    private $updateSectionCommand;
    
    /**
     * @var DeleteCommand 
     */
    private $deleteSectionCommand;
    
    public function __construct(
        InsertCommand $inertSectionCommand,
        UpdateCommand $updateSectionCommand,
        DeleteCommand $deleteSectionCommand
    )
    {
        $this->insertSectionCommand = $inertSectionCommand;
        $this->updateSectionCommand = $updateSectionCommand;
        $this->deleteSectionCommand = $deleteSectionCommand;
    }
    
    /**
     * @param array $data
     * @return \Forum\Entity\Section
     */
    public function create(array $data = [])
    {
        $section = new Section();
        
        if (array_key_exists("s_id", $data)) {
            $section->setId($data['s_id']);
        }
        
        if (array_key_exists("s_name", $data)) {
            $section->setName($data['s_name']);
        }
        
        if (array_key_exists("s_description", $data)) {
            $section->setDescription($data['s_description']);
        }
        
        if (array_key_exists("s_amount_topics", $data)) {
            $section->setAmountTopics((int)$data['s_amount_topics']);
        }
        
        if (array_key_exists("s_is_closed", $data)) {
            $closed = false;
            if (intval($data['s_is_closed']) === 1) {
                $closed = true;
            }
            $section->setIsClosed($closed);
        }
        
        if (array_key_exists("s_created_on", $data)) {
            $section->setCreatedOn(new \DateTime($data['s_created_on']));
        }
        
        return $section;
    }
    
    public function save(Section $section)
    {
        if(!$section->getUser() || !$section->getUser()->getId()) {
            throw new \InvalidArgumentException("Cannot save section without assigned user");
        }
        
        if ($section->getId()) {
            $this->update($section);
        } else {
            return $this->insert($section);
        }
    }
    
    private function insert(Section $section)
    {
        $this->insertSectionCommand->setSection($section);
        return $this->insertSectionCommand->execute();
    }
    
    private function update(Section $section)
    {
        $this->updateSectionCommand->setSection($section);
        return $this->updateSectionCommand->execute();
    }
    
    public function delete(Section $section)
    {
        $this->deleteSectionCommand->setSection($section);
        return $this->deleteSectionCommand->execute();
    }
   
}

