<?php

namespace Forum\Service;

class SectionManager
{
    /**
     * @param array $data
     * @return \Forum\Entity\Section
     */
    public function create(array $data = [])
    {
        $section = new \Forum\Entity\Section();
        
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
            $section->setAmountTopic((int)$data['s_amount_topics']);
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
   
}

