<?php

namespace Forum\Service\Factory;

use Forum\Model\Entity\Command\CommandFactory;
use Forum\Service\PostManager;

class PostManagerFactory
{
    /**
     * @return \Forum\Service\PostManager
     */
    public static function create()
    {
        $insertPostCommand = CommandFactory::create("Post\Insert");
        $updatePostCommand = CommandFactory::create("Post\Update");
        $deletePostCommand = CommandFactory::create("Post\Delete");
        
        return new PostManager($insertPostCommand, $updatePostCommand, $deletePostCommand);
    }
}