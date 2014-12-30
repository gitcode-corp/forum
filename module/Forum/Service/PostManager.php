<?php

namespace Forum\Service;

class PostManager
{
    /**
     * @param array $data
     * @return \Forum\Entity\Post
     */
    public function create(array $data = [])
    {
        $post = new \Forum\Model\Entity\Post();
        
        if (array_key_exists("p_id", $data)) {
            $post->setId($data['p_id']);
        }
        
        if (array_key_exists("p_content", $data)) {
            $post->setContent($data['p_content']);
        }
        
        if (array_key_exists("p_created_on", $data)) {
            $post->setCreatedOn(new \DateTime($data['p_created_on']));
        }
        
        return $post;
    }
   
}

