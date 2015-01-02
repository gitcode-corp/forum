<?php

namespace Forum\Model\Entity\Command\Section;

use Soft\AbstractCommand;

class UpdateAmountTopicCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $sectionId;
    
    /**
     * @var bool
     */
    private $increase = true;
    
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
    }
    
    public function decrease()
    {
        $this->increase = false;
    }
    
    public function execute()
    {
        $sql = "UPDATE sections SET ";
        
        if ($this->increase) {
            $sql .= "amount_topics = amount_topics+1 ";
        } else {
            $sql .= "amount_topics = amount_topics-1 ";
        }
        
        $sql .= "WHERE id =" .$this->escapeString($this->sectionId);
        
        return $this->update($sql);
    }
}