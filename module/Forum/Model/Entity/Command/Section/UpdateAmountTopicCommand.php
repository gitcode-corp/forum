<?php

namespace Forum\Model\Entity\Command\Section;

use Soft\AbstractCommand;

class UpdateAmountTopicCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $sectionId;
    
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
    }
    
    public function execute()
    {
        
        $sql = "UPDATE sections SET ";
        $sql .= "amount_topics = amount_topics+1 ";
        $sql .= "WHERE id =" .$this->escapeString($this->sectionId);
        
        return $this->update($sql);
    }
}