<?php

namespace Forum\Service;

class TopicManager
{
    /**
     * @param array $data
     * @return \Forum\Entity\Topic
     */
    public function create(array $data = [])
    {
        $topic = new \Forum\Model\Entity\Topic();
        
        if (array_key_exists("t_id", $data)) {
            $topic->setId($data['t_id']);
        }
        
        if (array_key_exists("t_name", $data)) {
            $topic->setName($data['t_name']);
        }
        
        if (array_key_exists("t_description", $data)) {
            $topic->setDescription($data['t_description']);
        }
        
        if (array_key_exists("t_amount_posts", $data)) {
            $topic->setAmountPosts((int)$data['t_amount_posts']);
        }
        
        if (array_key_exists("t_is_closed", $data)) {
            $closed = false;
            if (intval($data['t_is_closed']) === 1) {
                $closed = true;
            }
            $topic->setIsClosed($closed);
        }
        
        if (array_key_exists("t_created_on", $data)) {
            $topic->setCreatedOn(new \DateTime($data['t_created_on']));
        }
        
        return $topic;
    }
   
}

